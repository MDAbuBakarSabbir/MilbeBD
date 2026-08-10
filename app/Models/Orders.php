<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [];

    public function orderLogs()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }
}
