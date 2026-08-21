<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'sitetag',
        'phone',
        'email',
        'address',
        'site_logo',
        'site_logo_footer',
        'site_favicon',
        'meta_pixel',
        'google_analytics',
        'gtm_id',
        'meta_capi_token',
        'meta_test_event_code',
    ];
}
