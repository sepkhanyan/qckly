<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $fillable = ['area_en', 'area_ar'];


    protected $table = 'areas';

    public function locations()
    {
        return $this->hasMany('App\Locations', 'location_country_id');
    }
}
