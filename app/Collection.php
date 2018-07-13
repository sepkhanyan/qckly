<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['restaurant_id', 'subcategory_id', 'female_caterer_available', 'is_available', 'notes', 'price', 'name'];

    protected $table = 'collections';

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\MenuSubcategory', 'subcategory_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_id');
    }
}
