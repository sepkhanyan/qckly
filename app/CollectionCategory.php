<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionCategory extends Model
{
    protected $table = 'collection_categories';


    protected $fillable = [
        'name_en',
        'name_ar'
    ];


    public function collection()
    {
        return $this->hasMany('App\Collection', 'category_id');
    }


}
