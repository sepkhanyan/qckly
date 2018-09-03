<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';


    protected $fillable = [
        'restaurant_id',
        'subcategory_id',
        'is_available',
        'price',
        'name',
        'service_provide',
        'setup_time',
        'max_time',
        'requirements',
        'service_presentation',
        'description',
        'mealtime',
        'female_caterer_available',
        'max_qty',
        'min_qty',
        'persons_max_count',
        'allow_person_increase',
        'min_serve_to_person',
        'max_serve_to_person'
    ];


    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo('App\CollectionCategory', 'category_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_id');
    }

    public function cartItem ()
    {
        return $this->hasMany('App\UserCartItem', 'collection_id');
    }

    public function cartCollection ()
    {
        return $this->hasMany('App\UserCartCollection', 'collection_id');
    }
}
