<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['area_en', 'area_ar'];


    protected $table = 'areas';

    public function restaurant()
    {
        return $this->hasMany('App\Restaurant', 'area_id');
    }
}
