<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingMenu extends Model
{
    protected $table = 'editing_menus';


    protected $fillable = [
        'menu_id',
        'name_en',
        'description_en',
        'name_ar',
        'description_ar',
        'price',
        'image',
        'famous',
        'status'
    ];

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'menu_id');
    }
}
