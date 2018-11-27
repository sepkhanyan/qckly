<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingCollectionItem extends Model
{
    protected $table = 'editing_collection_items';


    protected $fillable = [
        'editing_collection_id',
        'collection_menu_id',
        'item_id',
        'quantity',
    ];


    public function editingCollection()
    {
        return $this->belongsTo('App\EditingCollection', 'editing_ collection_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }

    public function editingCollectionMenu()
    {
        return $this->belongsTo('App\EditingCollectionMenu', 'collection_menu_id', 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo('App\MenuCategory', 'collection_menu_id');
    }
}
