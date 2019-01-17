<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCollectionMenu extends Model
{
    protected $table = 'order_collection_menus';


    protected $fillable = [
        'order_id',
        'order_collection_id',
        'menu_id',
        'menu_en',
        'menu_ar'
    ];


    public function orderCollection()
    {
        return $this->belongsTo('App\OrderCollection', 'order_collection_id', 'collection_id');
    }


    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory', 'menu_id');
    }

    public function orderCollectionItem()
    {
        return $this->hasMany('App\OrderCollectionItem', 'order_collection_menu_id', 'menu_id');
    }
}
