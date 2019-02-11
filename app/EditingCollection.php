<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingCollection extends Model
{
    protected $table = 'editing_collections';


    protected $fillable = [
        'restaurant_id',
        'collection_id',
        'service_type_id',
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
        'food_list_en',
        'food_list_ar',
        'container_title_en',
        'container_title_ar',
        'mealtime_id',
        'female_caterer_available',
        'max_qty',
        'min_qty',
        'persons_max_count',
        'allow_person_increase',
        'min_serve_to_person',
        'max_serve_to_person',
    ];



    public function mealtime()
    {
        return $this->belongsTo('App\Mealtime', 'mealtime_id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function editingCollectionMenu()
    {
        return $this->hasMany('App\EditingCollectionMenu', 'editing_collection_id');
    }

    public function editingCollectionItem()
    {
        return $this->hasMany('App\EditingCollectionItem', 'editing_collection_id');
    }

    public function serviceType()
    {
        return $this->hasMany('App\EditingCollectionServiceType', 'editing_collection_id');
    }
}
