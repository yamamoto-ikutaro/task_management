@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center">予定登録</h1>
    {!! Form::open(['route'=>['scheduleRegister', $uri], 'files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::text('title', null, ['class'=>'col-sm-8']) !!}
            @if($errors->first('title'))
                <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('date', '日付：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::date('date', null) !!}
            @if($errors->first('date'))
                <p class="text-danger">{{ $errors->first('date') }}</p>
            @endif
        </div>
        <div class="form-group">
            <div class="d-flex">
                <div class="text-right" style="width:100px;">
                    <p>参加者：</p>
                </div>
                <div>
                    <div class="overflow-auto border" style="width:180px; height:200px; padding:10px; margin-left:4px;">
                    @foreach($users as $user)
                        <div>
                            {{ Form::checkbox('memberIds[]', $user->id, false, ['class' => 'mr-1','id' => $user->id]) }}
                            <label for = {{ $user->id }}>{{ $user->name }}</label>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <div>
                @if($errors->first('memberIds'))
                    <p class="text-danger">{{ $errors->first('memberIds') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('startTime', '開始時刻：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::time('startTime', null) !!}
            @if($errors->first('startTime'))
                <p class="text-danger">{{ $errors->first('startTime') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('endTime', '終了時刻：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::time('endTime', null) !!}
            @if($errors->first('endTime'))
                <p class="text-danger">{{ $errors->first('endTime') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('file', '資料：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::file('file') !!}
        </div>
        <div class="form-group row">
            {!! Form::label('comment', 'コメント：', ['class'=>'text-right', 'style'=>'width:115px; margin-right:3px;']) !!}
            {!! Form::textarea('comment', null, ['class'=>'col-sm-8']) !!}
        </div>
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
@endsection