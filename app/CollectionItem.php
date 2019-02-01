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
        'is_mandatory',
        'status'
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
        return $this->belongsTo('App\CollectionMenu', 'collection_menu_id');
    }

    public function approvedCollection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function approvedCollectionMenu()
    {
        return $this->hasMany('App\CollectionMenu', 'collection_menu_id');
    }

}
