<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';


    protected $fillable = [
        'area_en',
        'area_ar'
    ];


    public function restaurant()
    {
        return $this->hasMany('App\Restaurant', 'area_id');
    }
}
