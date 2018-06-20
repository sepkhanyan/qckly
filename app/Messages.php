<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = ['sender_id', 'date_added', 'send_type', 'recipient', 'subject', 'body', 'status'];


    protected $table = 'messages';
}
