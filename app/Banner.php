<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'name',
        'type',
        'click_url',
        'language_id',
        'alt_text',
        'image_code',
        'custom_code',
        'status'
    ];

}
