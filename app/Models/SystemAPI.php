<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAPI extends Model
{
    protected $fillable = ['api_name', 'api_key', 'api_secret', 'api_url', 'api_status'];
}
