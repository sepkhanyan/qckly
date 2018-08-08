<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'name', 'mobile_number', 'location', 'building_number', 'zone', 'is_apartment', 'apartment_number'];

    protected $table = 'addresses';


}
