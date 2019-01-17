<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';


    protected $fillable = [
        'name_en',
        'description_en',
        'name_ar',
        'description_ar',
        'price',
        'image',
        'category_id',
        'status',
        'famous',
        'approved'
    ];


    public function editingMenu()
    {
        return $this->hasOne('App\EditingMenu', 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo('App\MenuCategory', 'category_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant', 'restaurant_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'item_id');
    }

    public function editingCollectionItem()
    {
        return $this->hasMany('App\EditingCollectionItem', 'item_id');
    }

    public function cartItem()
    {
        return $this->hasMany('App\UserCartItem', 'item_id');
    }

    public function orderCollectionItem()
    {
        return $this->hasMany('App\OrderCollectionItem', 'item_id');
    }

    public function scopeName($query, $val)
    {
        if (!empty($val)) {
            return $query->where('name_en', 'like', '%' . $val . '%')
                ->orWhere('price', 'like', '%' . $val . '%')
                ->orWhere('description_en', 'like', '%' . $val . '%');
        }

        return $query;
    }
}
