<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $primaryKey = 'customer_group_id';


    protected $table = 'customers_groups';


    protected $fillable = [
        'group_name',
        'description',
        'approval'
    ];


    public function customer()
    {
        return $this->hasMany('App\Customer', 'customer_group_id', 'customer_group_id');
    }
}
