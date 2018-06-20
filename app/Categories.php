<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'description', 'status', 'parent_id', 'priority', 'image'];

    protected $table = 'categories';

    protected $primaryKey = 'category_id';
}
