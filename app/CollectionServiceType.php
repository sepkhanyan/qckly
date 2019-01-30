<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionServiceType extends Model
{
    protected $table = 'collection_service_type';

    protected $fillable = [
        'collection_id',
        'service_type_id',
        'name_en',
        'name_ar',
        'deleted'
    ];

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

//    public function  cartCollection()
//    {
//        return $this->hasOne('App\UserCartCollection', 'collection_id', 'collection_id');
//    }
}
