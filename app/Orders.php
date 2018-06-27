<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['customer_id', 'first_name', 'last_name', 'email', 'telephone', 'location_id', 'address_id', 'cart', 'total_items', 'comment', 'payment', 'order_type', 'date_added', 'date_modified', 'order_time', 'order_date', 'order_total', 'status_id', 'ip_address', 'user_agent', 'notify', 'assignee_id', 'invoice_no', 'invoice_prefix', 'invoice_time'];


    protected $table = 'orders';


    protected $primaryKey = 'order_id';
}
