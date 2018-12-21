<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected  $table = 'notifications';

    protected $fillable = [
        'to_device',
        'from_device',
        'message',
        'is_read',
        'notification_type',
        'order_id',
        'restaurant_id'
    ];
}
