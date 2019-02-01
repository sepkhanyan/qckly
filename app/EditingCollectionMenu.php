<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingCollectionMenu extends Model
{
    protected $table = 'editing_collection_menus';


    protected $fillable = [
        'editing_collection_id',
        'menu_id',
        'min_qty',
        'max_qty',
        'status'
    ];


    public function editingCollection()
    {
        return $this->belongsTo('App\EditingCollection', 'editing_collection_id');
    }


    public function category()
    {
        return $this->belongsTo('App\MenuCategory', 'menu_id');
    }

    public function editingCollectionItem()
    {
        return $this->hasMany('App\EditingCollectionItem', 'collection_menu_id');
    }
}
