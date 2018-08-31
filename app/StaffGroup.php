<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffGroup extends Model
{
    protected $table = 'staff_groups';


    protected $fillable = [
        'staff_group_name',
        'customer_account_access',
        'location_access',
        'permission'
    ];

}
