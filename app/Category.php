<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';


    protected $fillable = [
        'name',
        'description',
        'status',
        'image'
    ];



    public function menu()
    {
        return$this->hasMany('App\Menu', 'category_id');
    }

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'menu_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionMenu', 'menu_id');
    }
    public function collectionMenu()
    {
        return $this->hasMany('App\CollectionItem', 'collection_menu_id');
    }

}
