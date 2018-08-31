<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $table = 'mail_templates';


    protected $fillable = [
        'name',
        'language_id',
        'date_added',
        'date_updated',
        'status'
    ];

}
