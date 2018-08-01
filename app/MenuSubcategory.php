<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuSubcategory extends Model
{
    protected $fillable = ['subcategory_en', 'subcategory_ar'];


    protected $table = 'menu_subcategories';

    public function collection()
    {
        return $this->hasMany('App\Collection', 'subcategory_id');
    }


}
