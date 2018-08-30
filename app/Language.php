<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['code', 'name', 'image', 'idiom', 'status', 'can_delete'];

    protected $table = 'languages';


    protected $primaryKey = 'language_id';
}
