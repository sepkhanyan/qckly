<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingMenuCategory extends Model
{
    protected $table = 'editing_menu_categories';


    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image',
        'approved'
    ];

    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory', 'category_id');
    }
}
