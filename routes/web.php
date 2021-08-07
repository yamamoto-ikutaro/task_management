<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'SchedulesController@index')->name('topPage');

Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::get('schedule', 'SchedulesController@scheduleRegistrationForm')->name('scheduleRegister.get');
Route::post('schedule', 'SchedulesController@scheduleRegister')->name('scheduleRegister');

Route::get('schedule/{id}', 'SchedulesController@showSchedule')->name('showSchedule');
Route::get('editSchedule/{id}', 'SchedulesController@editSchedule')->name('editSchedule.get');
Route::put('updateSchedule/{id}', 'SchedulesController@updateSchedule')->name('schedule.update');
Route::delete('deleteSchedule/{id}', 'SchedulesController@deleteSchedule')->name('schedule.delete');

Route::get('download/{id}', 'SchedulesController@download')->name('download');

Route::get('task', 'TasksController@taskRegistrationForm')->name('taskRegister.get');
Route::post('task', 'TasksController@taskRegister')->name('taskRegister');
Route::get('task/{id}', 'TasksController@showTask')->name('showTask');
Route::get('editTask/{id}', 'TasksController@editTask')->name('editTask.get');
Route::put('updateTask/{id}', 'TasksController@updateTask')->name('task.update');
Route::delete('deleteTask/{id}', 'TasksController@deleteTask')->name('task.delete');

Route::group(['prefix'=>'user/{id}'], function(){
    Route::delete('accountDelete', 'UserController@accountDelete')->name('accountDelete');
    Route::get('userInfo', 'UserController@userInfo')->name('userInfo.get');
    Route::put('userInfoUpdate', 'UserController@userInfoUpdate')->name('userInfo.update');
    Route::put('userMessagePut', 'UserController@userMessagePut')->name('userMessagePut');
    Route::delete('userMessageDelete', 'UserController@userMessageDelete')->name('userMessageDelete');
});
Route::get('members_schedule', 'SchedulesController@members_schedule')->name('members_schedule');

Route::post('todo/{id}', 'TodoController@todo')->name('todo');
Route::delete('todo_del/{id}', 'TodoController@todo_del')->name('todo_del');
Route::get('todo_reminder/{id}', 'TodoController@todo_reminder')->name('todo_reminder');
Route::put('todo_reminder/{id}', 'TodoController@todo_update')->name('todo_update');
Route::post('todo_reminder_create/{id}', 'TodoController@todo_reminder_create')->name('todo_reminder_create');

Route::post('search_users', 'SchedulesController@search_users')->name('search_users');
Route::post('checking_users_add', 'UserController@checking_users_add')->name('checking_users_add');
Route::delete('checking_users_delete/{id}', 'UserController@checking_users_delete')->name('checking_users_delete');