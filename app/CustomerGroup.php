<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable = ['group_name', 'description', 'approval'];



    protected $primaryKey = 'customer_group_id';



    protected $table = 'customers_groups';

    public function customer()
    {
        return $this->hasMany('App\Customer', 'customer_group_id', 'customer_group_id');
    }
}
