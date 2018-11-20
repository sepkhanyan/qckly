<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $table = 'menu_categories';


    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image'
    ];


    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu', 'category_id');
    }

    public function cartItem()
    {
        return $this->hasMany('App\UserCartItem', 'menu_id');
    }

    public function collectionMenu()
    {
        return $this->hasOne('App\CollectionMenu', 'menu_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_menu_id');
    }

    public function scopeName($query, $val)
    {
        if (!empty($val)) {
            return $query->where('name_en', 'like', '%' . $val . '%')
                ->orWhere('description_en', 'like', '%' . $val . '%');
        }

        return $query;
    }

}
