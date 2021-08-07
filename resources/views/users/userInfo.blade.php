@extends('layouts.app')

@section('content')
@if(Auth::check())
    {!! Form::model($user, ['route' => ['userInfo.update', Auth::id()], 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', '氏名') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            @if($errors->first('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', null, ['class'=>'form-control']) !!}
            @if($errors->first('email'))
                <p class="text-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('password', 'パスワード') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
            @if($errors->first('password'))
                <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'パスワード確認') !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
            @if($errors->first('password_confirmation'))
                <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>
        {!! Form::submit('更新', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
    
    {!! Form::open(['route'=>['accountDelete', $user->id], 'method'=>'delete']) !!}
        {!! Form::submit('退会', ['class'=>'btn btn-danger mt-4']) !!}
    {!! Form::close() !!}
@endif
@endsection