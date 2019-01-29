<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditingCollectionServiceType extends Model
{
    protected $table = 'editing_collection_service_type';

    protected $fillable = [
        'editing_collection_id',
        'service_type_id',
        'name_en',
        'name_ar',
        'deleted'
    ];

    public function collection()
    {
        return $this->belongsTo('App\EditingCollection', 'editing_collection_id');
    }
}
