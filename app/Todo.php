<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

use App\User;

class Todo extends Model
{
    protected $fillable = ['content', 'send_at', 'file'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
