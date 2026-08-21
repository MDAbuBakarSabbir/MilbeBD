<?php

namespace App\Http\Controllers;

use App\Services\MetaCapiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Handle asynchronous browser events forwarded to Meta CAPI
     */
    public function trackEvent(Request $request): JsonResponse
    {
        $eventName = $request->input('event_name', 'PageView');
        $eventId = $request->input('event_id');
        $userData = (array) $request->input('user_data', []);
        $customData = (array) $request->input('custom_data', []);

        // Pass fbp/fbc if passed in body or auto-detected in cookies
        if ($request->has('fbp')) {
            $userData['fbp'] = $request->input('fbp');
        }
        if ($request->has('fbc')) {
            $userData['fbc'] = $request->input('fbc');
        }

        // Send event to Meta Conversions API
        $response = MetaCapiService::sendEvent($eventName, $userData, $customData, $eventId, $request);

        return response()->json([
            'success' => true,
            'event_name' => $eventName,
            'event_id' => $eventId,
            'meta_response' => $response,
        ]);
    }
}
