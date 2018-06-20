<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = ['customer_Id', 'sale_id', 'sale_type', 'author', 'location_id', 'quality', 'delivery', 'service', 'review_text', 'date_added', 'review'];


    protected $table = 'reviews';
}
