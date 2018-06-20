<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroups extends Model
{
    protected $fillable = ['group_name', 'description', 'approval'];

    protected $table = 'customers_groups';
}
