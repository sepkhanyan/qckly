<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';


    protected $primaryKey = 'customer_id';


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'salt',
        'telephone',
        'address_id',
        'security_question_id',
        'security_answer',
        'newsletter',
        'customer_group_id',
        'ip_address',
        'date_added',
        'status',
        'cart'
    ];


    public function customer()
    {
        return $this->belongsTo('App\CustomerGroup', 'customer_group_id', 'customer_group_id');
    }
}
