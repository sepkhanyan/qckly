<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCartItem extends Model
{
    protected $table = 'user_cart_items';


    protected $fillable = [
        'cart_collection_id',
        'item_id',
        'price',
        'quantity',
        'menu_id',
        'is_mandatory'
    ];


    public function cartCollection()
    {
        return $this->belongsTo('App\UserCartCollection', 'cart_collection_id');
    }


    public function menu()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }


    public function category()
    {
        return $this->belongsTo('App\MenuCategory', 'menu_id');
    }


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

}
