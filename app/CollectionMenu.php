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
    ];


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }


    public function category()
    {
        return $this->belongsTo('App\Category', 'menu_id');
    }

    public function collectionItem()
    {
        return $this->hasMany('App\CollectionItem', 'collection_menu_id', 'menu_id');
    }
}