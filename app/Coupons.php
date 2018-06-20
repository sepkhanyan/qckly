<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $fillable = ['name', 'code', 'type', 'discount', 'min_total', 'redemptions', 'customer_redemption', 'description', 'status', 'date_added', 'validity', 'fixed_date', 'fixed_from_time', 'fixed_to_time', 'period_start_date', 'period_end_date', 'recurring_every', 'recurring_from_time', 'recurring_to_time', 'order_restriction'];

    protected $table = 'coupons';
}
