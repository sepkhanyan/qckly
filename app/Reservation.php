<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['location_id', 'table_id', 'guest_num', 'occasion_id', 'customer_id', 'first_name', 'last_name', 'email', 'telephone', 'comment', 'reserve_time', 'reserve_date', 'date_added', 'date_modified', 'assignee_id', 'notify', 'ip_address', 'user_agent', 'status'];


    protected $table = 'reservations';
}
