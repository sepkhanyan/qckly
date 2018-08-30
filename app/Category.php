<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'status', 'parent_id', 'priority', 'image'];

    protected $table = 'categories';


    public function menu()
    {
        return$this->hasMany('App\Menu', 'category_id');
    }

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'menu_id');
    }

//    public function cartMenu ()
//    {
//        return $this->hasMany('App\Category', 'menu_id');
//    }
}
