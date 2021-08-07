<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Schedule;

class Schedule extends Model
{
    protected $fillable = ['user_id', 'date', 'startTime', 'endTime', 'title', 'file_url', 'comment'];
    
    public function users(){
        return $this->belongsToMany(User::class, 'members', 'schedule_id', 'user_id')->withTimestamps();
    }
    
    public function add_members($userId){
        $this->users()->attach($userId);
    }
    
    public function update_members($userId){
        $this->users()->sync($userId);
        return $this->users;
    }
}
