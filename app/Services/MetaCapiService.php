<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaCapiService
{
    /**
     * Send event to Meta Conversions API (CAPI)
     *
     * @param string $eventName (e.g. PageView, ViewContent, InitiateCheckout, Purchase)
     * @param array $userData Optional customer data (phone, email, name, city, etc.)
     * @param array $customData Optional event custom data (value, currency, content_name, etc.)
     * @param string|null $eventId Unique event ID for deduplication with browser pixel
     * @param Request|null $request
     * @return array|null Response from Meta Graph API
     */
    public static function sendEvent(
        string $eventName,
        array $userData = [],
        array $customData = [],
        ?string $eventId = null,
        ?Request $request = null
    ) {
        try {
            $settings = Settings::first();
            if (!$settings) {
                return null;
            }

            $pixelId = trim($settings->meta_pixel ?? '');
            $accessToken = trim($settings->meta_capi_token ?? '');

            // CAPI requires both Pixel ID and Access Token
            if (empty($pixelId) || empty($accessToken)) {
                return null;
            }

            $req = $request ?: request();
            $eventTime = time();
            $eventId = $eventId ?: ('evt_' . $eventTime . '_' . bin2hex(random_bytes(4)));

            // Prepare normalized & hashed user data for high Event Match Quality (EMQ)
            $formattedUserData = self::buildUserData($userData, $req);

            // Event payload item
            $eventPayload = [
                'event_name' => $eventName,
                'event_time' => $eventTime,
                'event_id' => (string) $eventId,
                'event_source_url' => $req->fullUrl(),
                'action_source' => 'website',
                'user_data' => $formattedUserData,
            ];

            if (!empty($customData)) {
                $eventPayload['custom_data'] = self::formatCustomData($customData);
            }

            // Top-level payload
            $postData = [
                'data' => [$eventPayload],
            ];

            // Add test event code if configured (for Meta Events Manager live testing)
            if (!empty($settings->meta_test_event_code)) {
                $postData['test_event_code'] = trim($settings->meta_test_event_code);
            }

            $url = "https://graph.facebook.com/v19.0/{$pixelId}/events";

            $response = Http::timeout(5)->post($url . '?access_token=' . urlencode($accessToken), $postData);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::warning('Meta CAPI Error Response: ' . $response->body());
                return null;
            }
        } catch (\Throwable $e) {
            Log::error('Meta CAPI Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build and hash user data according to Meta CAPI specification
     */
    protected static function buildUserData(array $data, Request $request): array
    {
        $userData = [];

        // Client IP Address
        $ip = $request->header('CF-Connecting-IP') ?: ($request->header('X-Forwarded-For') ?: $request->ip());
        if (!empty($ip)) {
            // If multiple IPs present in X-Forwarded-For, take the first one
            $ipParts = explode(',', $ip);
            $userData['client_ip_address'] = trim($ipParts[0]);
        }

        // Client User Agent
        $userAgent = $request->userAgent();
        if (!empty($userAgent)) {
            $userData['client_user_agent'] = $userAgent;
        }

        // FBP (Facebook Browser ID) Cookie
        $fbp = $data['fbp'] ?? $request->cookie('_fbp') ?? $request->header('x-fbp');
        if (!empty($fbp)) {
            $userData['fbp'] = trim($fbp);
        }

        // FBC (Facebook Click ID) Cookie or query param fbclid
        $fbc = $data['fbc'] ?? $request->cookie('_fbc');
        if (empty($fbc) && $request->has('fbclid')) {
            $fbclid = $request->get('fbclid');
            $fbc = 'fb.1.' . time() . '.' . $fbclid;
        }
        if (!empty($fbc)) {
            $userData['fbc'] = trim($fbc);
        }

        // Phone Number normalization and SHA-256 Hashing
        if (!empty($data['phone'])) {
            $phone = self::normalizePhone($data['phone']);
            if (!empty($phone)) {
                $userData['ph'] = [hash('sha256', $phone)];
            }
        }

        // Email normalization and SHA-256 Hashing
        if (!empty($data['email'])) {
            $email = strtolower(trim($data['email']));
            $userData['em'] = [hash('sha256', $email)];
        }

        // Name (First & Last name)
        if (!empty($data['name'])) {
            $nameParts = explode(' ', trim($data['name']));
            $firstName = strtolower(trim($nameParts[0]));
            $userData['fn'] = [hash('sha256', $firstName)];

            if (count($nameParts) > 1) {
                $lastName = strtolower(trim(end($nameParts)));
                $userData['ln'] = [hash('sha256', $lastName)];
            }
        }

        // City
        if (!empty($data['city'])) {
            $city = strtolower(trim(preg_replace('/[^a-z0-9]/i', '', $data['city'])));
            if (!empty($city)) {
                $userData['ct'] = [hash('sha256', $city)];
            }
        }

        // Country default (Bangladesh 'bd')
        $country = !empty($data['country']) ? strtolower(trim($data['country'])) : 'bd';
        $userData['country'] = [hash('sha256', $country)];

        return $userData;
    }

    /**
     * Normalize Bangladeshi / International phone numbers for Meta hashing
     */
    protected static function normalizePhone(string $phone): string
    {
        // Remove all non-digits
        $digits = preg_replace('/\D+/', '', $phone);

        // If starts with 0 and length is 11 (e.g. 01712345678), prepend BD code 88
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = '88' . $digits;
        } elseif (strlen($digits) === 10 && str_starts_with($digits, '1')) {
            $digits = '880' . $digits;
        }

        return $digits;
    }

    /**
     * Format custom data for e-commerce events
     */
    protected static function formatCustomData(array $customData): array
    {
        $formatted = [];

        if (isset($customData['currency'])) {
            $formatted['currency'] = strtoupper($customData['currency']);
        } else {
            $formatted['currency'] = 'BDT';
        }

        if (isset($customData['value'])) {
            $formatted['value'] = (float) $customData['value'];
        }

        if (isset($customData['content_name'])) {
            $formatted['content_name'] = (string) $customData['content_name'];
        }

        if (isset($customData['content_type'])) {
            $formatted['content_type'] = (string) $customData['content_type'];
        } else {
            $formatted['content_type'] = 'product';
        }

        if (isset($customData['content_ids'])) {
            $formatted['content_ids'] = is_array($customData['content_ids'])
                ? array_map('strval', $customData['content_ids'])
                : [strval($customData['content_ids'])];
        }

        if (isset($customData['contents'])) {
            $formatted['contents'] = $customData['contents'];
        }

        if (isset($customData['num_items'])) {
            $formatted['num_items'] = (int) $customData['num_items'];
        }

        return $formatted;
    }
}
