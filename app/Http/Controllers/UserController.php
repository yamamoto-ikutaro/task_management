<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function accountDelete($id){
        User::find($id)->delete();
        return view('users/afterDeleteAccount');
    }
    
    public function userInfo($id){
        if(\Auth::check()){
            $user = User::find($id);
            return view('users/userInfo', ['user'=>$user]);
        }
        
        else{
             return view('welcome');
        }
        
    }
    
    public function userInfoUpdate(Request $request, $id){
        // dd($request);
        $request->validate([
            'name'=>'required|max:15',
            'email'=>'required|max:50',
            'password'=>'required|same:password_confirmation|max:15',
            'password_confirmation'=>'required|max:15',
            ]);
            
        $user = User::find($id);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            ]);
            
        return view('users/afterEditUserInfo', ['user'=>$user]);
    }
    
    
    public function checking_users_add(Request $request){
        // dd($request);
        // ▼参考
        // 1. https://qiita.com/amymd/items/69eeebe593f0b0d10757
        // 2. https://www.yoheim.net/blog.php?q=20190101
        // ▼uniqueをwhere句で範囲指定した
        $request->validate(['check' => ['required', Rule::unique('checks', 'check_id')->where('user_id', \Auth::id())]]);
        \Auth::User()->add_check_members($request->check);
        
        return redirect()->route('members_schedule');
    }
    
    public function checking_users_delete($id){
        \Auth::User()->del_check_members($id);
        return back();
    }
    
    public function userMessagePut(Request $request, $id){
        $request->validate(['message' => 'required']);
        User::find($id)->update([
            'message' => $request->message,
        ]);
        
        return redirect()->route('topPage');
    }
    
    public function userMessageDelete($id){
        User::find($id)->update([
            'message' => '',
        ]);
        return back();
    }
    
}
