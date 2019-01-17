<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCollectionItem extends Model
{
    protected $table = 'order_collection_items';


    protected $fillable = [
        'order_id',
        'order_collection_id',
        'order_collection_menu_id',
        'item_id',
        'item_en',
        'item_ar',
        'item_price',
        'quantity'
    ];

    public function orderCollectionMenu()
    {
        return $this->belongsTo('App\OrderCollectionMenu', 'order_collection_menu_id', 'menu_id');
    }

    public function orderCollection()
    {
        return $this->belongsTo('App\OrderCollection', 'order_collection_id', 'collection_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }
}
