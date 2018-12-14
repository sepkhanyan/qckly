<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
   protected  $table = 'all_devices';

   protected $fillable = [
       'user_id',
       'device_token',
       'device_type',
       'lang'
   ];
}
