<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuSubcategory extends Model
{
    protected $table = 'menu_subcategories';


    protected $fillable = [
        'name_en',
        'name_ar'
    ];


    public function collection()
    {
        return $this->hasMany('App\Collection', 'subcategory_id');
    }


}
