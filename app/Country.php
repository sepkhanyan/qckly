<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['country_name', 'iso_code_2', 'iso_code_3', 'format', 'status', 'flag'];

    protected $table = 'countries';
}
