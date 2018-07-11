<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $fillable = ['collection_id', 'menu_id', 'min_count', 'max_count'];

    protected $table = 'collection_items';


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menus', 'menu_id');
    }
}
