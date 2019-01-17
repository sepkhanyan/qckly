<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCollection extends Model
{
    protected $table = 'order_collections';


    protected $fillable = [
        'order_id',
        'restaurant_id',
        'restaurant_en',
        'restaurant_ar',
        'collection_id',
        'collection_en',
        'collection_ar',
        'collection_category_id',
        'collection_category_en',
        'collection_category_ar',
        'collection_price',
        'subtotal',
        'female_caterer',
        'special_instruction',
        'service_type_id',
        'service_type_en',
        'service_type_ar',
        'quantity',
        'persons_count'
    ];


    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function collectionCategory()
    {
        return $this->belongsTo('App\CollectionCategory', 'collection_category_id');
    }

    public function serviceType()
    {
        return $this->belongsTo('App\CategoryRestaurant', 'service_type_id');
    }

    public function orderCollectionMenu()
    {
        return $this->hasMany('App\OrderCollectionMenu', 'order_collection_id', 'collection_id');
    }

    public function orderCollectionItem()
    {
        return $this->hasMany('App\OrderCollectionItem', 'order_collection_id', 'collection_id');
    }
}
