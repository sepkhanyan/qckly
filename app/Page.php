<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['language_id', 'name', 'title', 'heading', 'content', 'meta_description', 'meta_keywords', 'layout_id', 'navigation', 'date_added', 'date_updated', 'status'];

    protected $table = 'pages';
}
