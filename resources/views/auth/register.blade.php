@extends('layouts.app')

@section('content')
    <h1 class="text-center">ユーザー登録</h1>
    {!! Form::open(['route'=>'signup.post']) !!}
        <div class="form-group">
            {!! Form::label('name', '氏名') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            @if($errors->first('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Eメール') !!}
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
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection