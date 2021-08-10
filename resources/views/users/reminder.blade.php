@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">{{ 'ToDoの更新/リマインダー作成' }}</h1>
    
    {!! Form::model($todo, ['route'=>['todo_update', $todo->id], 'method'=>'put']) !!}
        <div class="form-group">
            {!! Form::label('content', 'Todo：') !!}
            {!! Form::text('content', null, ['class' => 'form-control']) !!}
        </div>
        @if($errors->first('content'))
            <p class="text-danger">{{ $errors->first('content') }}</p>
        @endif
        {!! Form::submit('更新', ['class'=>'btn btn-primary mb-2']) !!}
    {!! Form::close() !!}
    
    {!! Form::open(['route'=>['todo_del', $todo->id], 'method'=>'delete']) !!}
        {!! Form::button('削除', ['class'=>'btn btn-danger mb-4', 'type'=>'submit']) !!}
    {!! Form::close() !!}
    
    <h3 class="mb-0">▼リマインダー作成（メールでリマインドします）</h3>
    {!! Form::open(['route'=>['todo_reminder_create', $todo->id], 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('send_at', 'リマインド日：') !!}
            {!! Form::datetimeLocal('send_at', isset($todo->send_at) ? str_replace(" ", "T", $todo->send_at) : '') !!}
            @if($errors->first('send_at'))
                <p class="text-danger">{{ $errors->first('send_at') }}</p>
            @endif
        </div>
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
@endsection