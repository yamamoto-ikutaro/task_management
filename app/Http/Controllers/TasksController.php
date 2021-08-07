<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Schedule;

use App\Task;

use App\Task_member;

class TasksController extends Controller
{
    public function taskRegistrationForm(Request $request){
        // dd($request);
        if(\Auth::check()){
            $users = User::get();
            $uri = $request->getRequestUri();
            return view('task/taskRegistration', ['users'=>$users, 'uri'=>$uri]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function taskRegister(Request $request){
        $request->validate(['memberIds'=>'required',
                            'title'=>'required|max:50',
                            'start_date'=>'required',
                            'deadline'=>'required',]);
        
        $task = Task::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'comment' => ($request->has('comment')) ? $request->comment : '',
        ]);

        $memberIds = $request->memberIds;
        $task->add_members($memberIds);
        
        $uri = $request->getRequestUri();
        // dd($uri);
        
        if(strpos($uri, 'members_schedule')){
            return redirect(route('members_schedule'));
        } else{
            return redirect('/');
        }
    }
    
    public function showTask($id){
        if(\Auth::check()){
            $task = Task::find($id);
            $task_members = $task->users;
            $start_date = date('m月d日', strtotime($task->start_date));
            $deadline = date('m月d日', strtotime($task->deadline));
            return view('task/showTask',
                        ['task'=>$task,
                        'task_members'=>$task_members,
                        'start_date'=>$start_date,
                        'deadline'=>$deadline]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function editTask($id){
        if(\Auth::check()){
            $task = Task::find($id);
            $users = User::get();
            $task_members = $task->users;
            
            $data = [];
            
            $data = ['task'=>$task, 'users'=>$users, 'task_members'=>$task_members];
            
            return view('task/editTask', $data);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function updateTask(Request $request, $id){
            $request->validate(['memberIds'=>'required',
                            'title'=>'required|max:50',
                            'start_date'=>'required',
                            'deadline'=>'required',]);
        
        $task = Task::find($id);
        
        $task->update([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'comment' => ($request->has('comment')) ? $request->comment : '',
        ]);
 
        $task_members = $task->update_members($request->memberIds);

        $users = User::get();
        $start_date = date('m月d日',  strtotime($task->start_date));
        $deadline = date('m月d日',  strtotime($task->deadline));
        
        return view('task/afterEditTask',
            ['task'=>$task,
            'users'=>$users,
            'task_members'=>$task_members,
            'start_date'=>$start_date,
            'deadline'=>$deadline]);
    }
    
    public function deleteTask($id){
        $task = Task::find($id);
        $task->delete();
        return view('task.afterDeleteTask');
    }
    
}