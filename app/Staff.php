<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['staff_name', 'staff_email', 'staff_group_id', 'staff_location_id', 'timezone', 'language_id', 'date_added', 'staff_status'];


    protected $table = 'staffs';
}
