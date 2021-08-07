<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Schedule;
use App\Task;
use App\Todo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function schedules(){
        return $this->belongsToMany(Schedule::class, 'members', 'user_id', 'schedule_id')->withTimestamps();
    }
    
    
    public function tasks(){
        return $this->belongsToMany(Task::class, 'task_members', 'user_id', 'task_id')->withTimestamps();
    }
    
    public function todo(){
        return $this->hasMany(Todo::class);
    }
    
    public function check_members(){
        return $this->belongsToMany(User::class, 'checks', 'user_id', 'check_id')->withTimestamps();
    }
    
    public function checked_members(){
        return $this->belongsToMany(User::class, 'checks', 'check_id', 'user_id')->withTimestamps();
    }
    
    public function add_check_members($id){
        $this->check_members()->attach($id);
    }
    
    public function del_check_members($id){
        $this->check_members()->detach($id);
    }
}
