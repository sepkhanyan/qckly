<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $table = 'collection_items';


    protected $fillable = [
        'collection_id',
        'collection_menu_id',
        'item_id',
        'quantity',
    ];


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }

    public function collectionMenu()
    {
        return $this->belongsTo('App\CollectionMenu', 'collection_menu_id', 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'collection_menu_id');
    }
}
