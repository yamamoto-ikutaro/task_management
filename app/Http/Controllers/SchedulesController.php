<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Schedule;

use App\Member;

use App\Task;

use App\Task_member;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use Illuminate\Foundation\Auth\ConfirmsPasswords;

use Illuminate\Validation\Rule;

class SchedulesController extends Controller
{
    
    public function index(Request $request){
        // $test = $request->query();
        // dd($test);
        if(\Auth::check()){
        
            $w = ($request->has('w')) ? $request->w : 0;
            // $now = time() + $w * 7 * 24 * 60 * 60;
            
            $calender = $request->calender;
            
            if($calender){
                $start_date = Carbon::parse($calender)->addWeek($w)->format('Y-m-d');
                $end_date   = Carbon::parse($calender)->addWeek($w)->addDay(6)->format('Y-m-d');
            } else {
                $start_date = Carbon::now()->addWeek($w)->format('Y-m-d');
                $end_date   = Carbon::now()->addWeek($w)->addDay(6)->format('Y-m-d');
            }
            
            $schedules = Schedule::where('date', '>=', $start_date )->where('date', '<=', $end_date)->get();
            $members = Member::get();
            $tasks = Task::where('start_date', '<=', $end_date)->where('deadline', '>=', $start_date)->get();
            $user = \Auth::User();
            
            $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
            
            // for($i=0; $i<7; $i++){
            //     $dates[] = date("m/d", $now + $i * 24 * 60 * 60);
            // }
            
            for($i=0; $i<7; $i++){
                $dates[] = Carbon::parse($start_date)->addDay($i)->Format('m/d');
            }
            
            $message = $user->message;
            
            $query = $request->query('message');
            // dd($query);
            
            return view('welcome',
                        ['user'=>$user,
                        'schedules'=>$schedules,
                        'members'=>$members,
                        'tasks'=>$tasks,
                        'dates'=>$dates,
                        'week'=>$week,
                        'calender'=>$calender,
                        'message'=>$message,
                        'query'=>$query,
                        'w'=>$w,]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function scheduleRegistrationForm(Request $request){
        // dd($request);
        if(\Auth::check()){
            $users = User::get();
            $uri = $request->getRequestUri();
            return view('schedule/scheduleRegistration', ['users'=>$users, 'uri'=>$uri]);
        }
        
        else{
             return view('welcome');
        }
    }
    
    public function scheduleRegister(Request $request){
        // dd($request);
        $request->validate(['title'=>'required|max:50',
                            'date'=>'required',
                            'memberIds'=>'required',
                            'startTime'=>'required',
                            'endTime'=>'required',
                            ]);
        if($request->file){
            $file = $request->file('file');
            // dd($file);
            $originalName = $file->getClientOriginalName();
            $now = time();
            $path = Storage::disk('s3')->putFileAs('/'.$now, $file, $originalName, 'public');
        }
        
        
        $schedule = Schedule::create([
                'date'=>$request->date,
                'startTime'=>$request->startTime,
                'endTime'=>$request->endTime,
                'title'=>$request->title,
                'file_url'=>($request->has('file')) ? $path : '',
                'comment'=>($request->has('comment')) ? $request->comment : '',
                ]);
            
        $memberIds = $request->memberIds;
        $schedule->add_members($memberIds);
        
        $uri = $request->getRequestUri();
        // dd($uri);
        
        if(strpos($uri, 'members_schedule')){
            return redirect(route('members_schedule'));
        } else{
            return redirect('/');
        }
    }
    
    public function showSchedule($id){
        if(\Auth::check()){
            $schedule = Schedule::find($id);
            $members = $schedule->users;
            $date = date('m月d日',  strtotime($schedule->date));
            $startTime = date('H時i分',  strtotime($schedule->startTime));
            $endTime = date('H時i分',  strtotime($schedule->endTime));
    
            return view('schedule/showSchedule',
                        ['schedule'=>$schedule,
                        'members'=>$members,
                        'date'=>$date,
                        'startTime'=>$startTime,
                        'endTime'=>$endTime]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function download($id){
        $file_url = Schedule::find($id)->file_url;
        return Storage::disk('s3')->download($file_url);
    }

    public function editSchedule($id){
        if(\Auth::check()){
            $schedule = Schedule::find($id);
            $users = User::get();
            $members = $schedule->users;
            
            $data = [];
            
            $data = ['schedule'=>$schedule, 'users'=>$users, 'members'=>$members];
            
            return view('schedule/editSchedule', $data);
        }
        
        else{
             return view('welcome');
        }
    }
    
    
    public function updateSchedule(Request $request, $id){
            $request->validate(['title'=>'required|max:50',
                                'date'=>'required',
                                'memberIds'=>'required',
                                'startTime'=>'required',
                                'endTime'=>'required',
                                ]);
        
        $schedule = Schedule::find($id);
        
        
        if($request->has('file')){
            Storage::disk('s3')->delete($schedule->file_url);
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $now = time();
            $path = Storage::disk('s3')->putFileAs('/'.$now, $file, $originalName, 'public');
        }
 
        $schedule->update([
            'date'=>$request->date,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime,
            'title'=>$request->title,
            'file_url'=>($request->has('file')) ? $path : $schedule->file_url,
            'comment'=>($request->has('comment')) ? $request->comment : '',
        ]);

        $members = $schedule->update_members($request->memberIds);

        $users = User::get();
        $date = date('m月d日',  strtotime($schedule->date));
        $startTime = date('H時i分',  strtotime($schedule->startTime));
        $endTime = date('H時i分',  strtotime($schedule->endTime));
        
        
        return view('schedule/afterEditSchedule',
                    ['schedule'=>$schedule,
                    'users'=>$users,
                    'members'=>$members,
                    'date'=>$date,
                    'startTime'=>$startTime,
                    'endTime'=>$endTime]);
    }
    
    public function deleteSchedule($id){
        $schedule = Schedule::find($id);
        
        Storage::disk('s3')->delete($schedule->file_url);
        
        $schedule->delete();
        return view('schedule.afterDeleteSchedule');
    }
    
    public function members_schedule(Request $request){
        // dd($request);
        if(\Auth::check()){
            if($request->has('keyword')){
                $request->validate(['keyword' => 'required']);
            }
    
            $w = ($request->has('w')) ? $request->w : 0;
            // $now = time() + $w * 7 * 24 * 60 * 60;
            
            $calender = $request->calender;
            
            if($calender){
                $start_date = Carbon::parse($calender)->addWeek($w)->format('Y-m-d');
                $end_date   = Carbon::parse($calender)->addWeek($w)->addDay(6)->format('Y-m-d');
            } else {
                $start_date = Carbon::now()->addWeek($w)->format('Y-m-d');
                $end_date   = Carbon::now()->addWeek($w)->addDay(6)->format('Y-m-d');
            }
            
            $schedules = Schedule::where('date', '>=', $start_date )->where('date', '<=', $end_date)->get();
            $members = Member::get();
            $tasks = Task::where('start_date', '<=', $end_date)->where('deadline', '>=', $start_date)->get();
            $task_members = Task_member::get();
            
            $week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
            
            // for($i=0; $i<7; $i++){
            //     $dates[] = date("m/d", $now + $i * 24 * 60 * 60);
            // }
            
            for($i=0; $i<7; $i++){
                $dates[] = Carbon::parse($start_date)->addDay($i)->Format('m/d');
            }
            
            if(\Auth::check()){
                $users = \Auth::User()->check_members;
            } else{
                $users = 'null';
            }
            
            if($request->has('keyword')){
                 $keyword = $request->keyword;
                 
                 $search_result = [];
                 $search_result = User::where('name', 'like', '%'."$keyword".'%')->get();
    
            } else {
                 $search_result = 'not_serched';
            }
            
            // dd($search_result);
            
            return view('users/members_schedule',
                        ['users'=>$users,
                        'search_result'=>$search_result,
                        'schedules'=>$schedules,
                        'members'=>$members,
                        'tasks'=>$tasks,
                        'task_members'=>$task_members,
                        'dates'=>$dates,
                        'week'=>$week,
                        'calender'=>$calender,
                        'w'=>$w,]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
}