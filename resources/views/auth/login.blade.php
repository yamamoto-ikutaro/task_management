@extends('layouts.app')

@section('content')
    {!! Form::open(['route'=>'login']) !!}
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
    {!! Form::submit('ログイン', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection