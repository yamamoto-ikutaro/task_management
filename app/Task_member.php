<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task_member extends Model
{
    protected $fillable = ['user_id', 'task_id'];
}
