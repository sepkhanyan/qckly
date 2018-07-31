<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'description', 'status', 'parent_id', 'priority', 'image'];

    protected $table = 'categories';


    public function menu()
    {
        return$this->hasMany('App\Menus', 'menu_category_id');
    }

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'menu_id');
    }
}
