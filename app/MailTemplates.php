<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplates extends Model
{
    protected $fillable = ['name', 'language_id', 'date_added', 'date_updated', 'status'];


    protected $table = 'mail_templates';
}
