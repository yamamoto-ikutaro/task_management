@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center">業務登録</h1>
    {!! Form::open(['route'=>['taskRegister', $uri]]) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル：') !!}
            {!! Form::text('title', null, ['class'=>'col-sm-8']) !!}
            @if($errors->first('title'))
                <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('start_date', '着手日：') !!}
            {!! Form::date('start_date', null) !!}
            @if($errors->first('start_date'))
                <p class="text-danger">{{ $errors->first('start_date') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('deadline', '納期：') !!}
            {!! Form::date('deadline', null) !!}
            @if($errors->first('deadline'))
                <p class="text-danger">{{ $errors->first('deadline') }}</p>
            @endif
        </div>
        <div class="form-group">
            <div class="d-flex">
                <div>
                    <p>担当者：</p>
                </div>
                <div>
                    @foreach($users as $user)
                    <div>
                        {{ Form::checkbox('memberIds[]', $user->id, false, ['class' => 'mr-1', 'id' => $user->id]) }}
                        <label for = {{ $user->id }}>{{ $user->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                @if($errors->first('memberIds'))
                    <p class="text-danger">{{ $errors->first('memberIds') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('comment', 'コメント：') !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
        </div>
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
@endsection