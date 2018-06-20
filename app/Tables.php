<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
   protected $fillable = ['table_name', 'min_capacity', 'max_capacity', 'table_status'];


   protected $table = 'tables';
}
