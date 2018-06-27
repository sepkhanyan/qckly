<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    protected $fillable = ['code', 'name', 'image', 'idiom', 'status', 'can_delete'];

    protected $table = 'languages';


    protected $primaryKey = 'language_id';
}
