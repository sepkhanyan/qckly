<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';


   protected $fillable = [
       'table_name',
       'min_capacity',
       'max_capacity',
       'table_status'
   ];

}
