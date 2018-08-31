<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $table = 'collection_items';


    protected $fillable = [
        'collection_id',
        'item_id',
        'min_count',
        'max_count'
    ];


    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'item_id');
    }
}
