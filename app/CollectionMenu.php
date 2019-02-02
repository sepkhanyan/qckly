<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionMenu extends Model
{
    protected $table = 'collection_menus';


    protected $fillable = [
        'collection_id',
        'menu_id',
        'min_qty',
        'max_qty',
        'status'
    ];


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }


    public function category()
    {
        return $this->belongsTo('App\MenuCategory', 'menu_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_menu_id');
    }

    public function menu()
    {
        return $this->hasMany('App\Menu', 'category_id', 'menu_id')->whereDoesntHave('collectionItem');
    }

    public function approvedCollectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_menu_id')->where('status', 1);
    }
}
