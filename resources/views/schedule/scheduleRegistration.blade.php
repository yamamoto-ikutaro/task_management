@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center">予定登録</h1>
    {!! Form::open(['route'=>['scheduleRegister', $uri], 'files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル：') !!}
            {!! Form::text('title', null, ['class'=>'col-sm-8']) !!}
            @if($errors->first('title'))
                <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('date', '日付：') !!}
            {!! Form::date('date', null) !!}
            @if($errors->first('date'))
                <p class="text-danger">{{ $errors->first('date') }}</p>
            @endif
        </div>
        <div class="form-group">
            <div class="d-flex">
                <div>
                    <p>参加者：</p>
                </div>
                <div>
                    @foreach($users as $user)
                    <div>
                        {{ Form::checkbox('memberIds[]', $user->id, false, ['class' => 'mr-1','id' => $user->id]) }}
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
            {!! Form::label('startTime', '開始時刻：') !!}
            {!! Form::time('startTime', null) !!}
            @if($errors->first('startTime'))
                <p class="text-danger">{{ $errors->first('startTime') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('endTime', '終了時刻：') !!}
            {!! Form::time('endTime', null) !!}
            @if($errors->first('endTime'))
                <p class="text-danger">{{ $errors->first('endTime') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('file', '資料：') !!}
            {!! Form::file('file') !!}
        </div>
        <div class="form-group">
            {!! Form::label('comment', 'コメント：') !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
        </div>
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
@endsection