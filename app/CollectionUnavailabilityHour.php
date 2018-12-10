<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionUnavailabilityHour extends Model
{
    protected $table = 'collection_unavailability_hours';


    protected $fillable = [
        'weekday',
        'start_time',
        'end_time',
        'status',
        'type',
        'collection_id'
    ];

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }
}
