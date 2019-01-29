<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';


    protected $fillable = [
        'restaurant_id',
        'category_id',
        'delivery_hours',
        'is_available',
        'price',
        'name_en',
        'name_ar',
        'service_provide_en',
        'service_provide_ar',
        'setup_time',
        'max_time',
        'requirements_en',
        'requirements_ar',
        'service_presentation_en',
        'service_presentation_ar',
        'description_en',
        'description_ar',
        'mealtime_id',
        'female_caterer_available',
        'max_qty',
        'min_qty',
        'persons_max_count',
        'allow_person_increase',
        'min_serve_to_person',
        'max_serve_to_person',
        'approved',
        'image',
        'deleted'
    ];


    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function category()
    {
        return $this->belongsTo('App\CollectionCategory', 'category_id');
    }


    public function unavailabilityHour()
    {
        return $this->hasMany('App\CollectionUnavailabilityHour', 'collection_id');
    }

    public function mealtime()
    {
        return $this->belongsTo('App\Mealtime', 'mealtime_id');
    }

//    public function serviceType()
//    {
//        return $this->belongsTo('App\CategoryRestaurant', 'service_type_id');
//    }

    public function serviceType()
    {
        return $this->hasMany('App\CollectionServiceType', 'collection_id');
    }

    public function editingCollection()
    {
        return $this->hasOne('App\EditingCollection', 'collection_id');
    }

    public function orderCollection()
    {
        return $this->hasOne('App\OrderCollection', 'collection_id');
    }

    public function collectionMenu()
    {
        return $this->hasMany('App\CollectionMenu', 'collection_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_id');
    }

//    public function serviceType()
//    {
//        return $this->hasMany('App\Collection', 'collection_id');
//    }

    public function cartCollection()
    {
        return $this->hasMany('App\UserCartCollection', 'collection_id');
    }

    public function scopeName($query, $val)
    {
        if (!empty($val)) {
            return $query->where('name_en', 'like', '%' . $val . '%')
                ->orWhere('price', 'like', '%' . $val . '%');
        }

        return $query;
    }
}
