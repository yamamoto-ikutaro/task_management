<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

use Carbon\Carbon;

class TodoController extends Controller
{
    public function todo(Request $request){
        // dd($request);
        if(\Auth::check()){
            $todos = \Auth::User()->todo()->create([
                'content' => $request->content,
            ]);
            
            return back();
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function todo_del($id){
        // dd($id);
        Todo::find($id)->delete();

        return redirect()->route('topPage');
    }
    
    public function todo_reminder($id){
        if(\Auth::check()){
            $todo = Todo::find($id);
            return view('users.reminder', ['todo'=>$todo]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function todo_update(Request $request, $id){
        Todo::find($id)->update([
            'content' => $request->content,
        ]);
        
        return redirect()->route('topPage');
    }
    
    public function todo_reminder_create(Request $request, $id){
        // dd($request);
        $request->validate(['send_at' => 'required']);
        
        $sent_at = str_replace(array("T"), '', $request->send_at);
        $sent_at = Carbon::parse($sent_at)->format('Y-m-d H:i');
        
        Todo::find($id)->update([
            'send_at' => $sent_at,
        ]);
        
        return redirect()->route('topPage');
    }
    
}
