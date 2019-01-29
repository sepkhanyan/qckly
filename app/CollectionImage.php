<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    protected $table = 'collection_images';

    protected $fillable = [
        'collection_id',
        'image'
    ];

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }
}
