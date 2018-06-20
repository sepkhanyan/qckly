<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityQuestions extends Model
{
    protected $fillable = ['text', 'priority'];



    protected $table = 'security_questions';
}
