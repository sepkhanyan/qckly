<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $fillable = ['country_id', 'currency_name', 'country_code', 'country_symbol', 'currency_rate', 'symbol_position', 'thousand_sign', 'decimal_sign', 'decimal_position', 'iso_alpha_2', 'iso_alpha_3', 'iso_numeric', 'flag', 'currency_status
    ', 'date_modified'];

    protected $table = 'currencies';
}
