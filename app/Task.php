<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Task extends Model
{
    protected $fillable = ['title', 'deadline', 'start_date', 'comment'];
    
    public function users(){
        return $this->belongsToMany(User::class, 'task_members', 'task_id', 'user_id')->withTimestamps();
    }
    
    public function add_members($userId){
        $this->users()->attach($userId);
    }
    
    public function update_members($userId){
        $this->users()->sync($userId);
        return $this->users;
    }
}
