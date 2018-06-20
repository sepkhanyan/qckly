<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $fillable = ['name', 'type', 'click_url', 'language_id', 'alt_text', 'image_code', 'custom_code', 'status'];

    protected $table = 'banners';
}
