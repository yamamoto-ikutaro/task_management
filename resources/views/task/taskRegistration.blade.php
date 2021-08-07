@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center">業務登録</h1>
    {!! Form::open(['route'=>['taskRegister', $uri]]) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::text('title', null, ['class'=>'col-sm-8']) !!}
            @if($errors->first('title'))
                <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('start_date', '着手日：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::date('start_date', null) !!}
            @if($errors->first('start_date'))
                <p class="text-danger">{{ $errors->first('start_date') }}</p>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('deadline', '納期：', ['class'=>'text-right', 'style'=>'width:100px;']) !!}
            {!! Form::date('deadline', null) !!}
            @if($errors->first('deadline'))
                <p class="text-danger">{{ $errors->first('deadline') }}</p>
            @endif
        </div>
        <div class="form-group">
            <div class="d-flex">
                <div class = "text-right" style = "width:100px;">
                    <p>担当者：</p>
                </div>
                <div>
                    <div class="overflow-auto border" style="width:180px; height:200px; padding:10px; margin-left:4px;">
                    @foreach($users as $user)
                        <div>
                            {{ Form::checkbox('memberIds[]', $user->id, false, ['class' => 'mr-1', 'id' => $user->id]) }}
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
        <div class="form-group row">
            {!! Form::label('comment', 'コメント：', ['class'=>'text-right', 'style'=>'width:115px; margin-right:3px;']) !!}
            {!! Form::textarea('comment', null, ['class'=>'col-sm-8']) !!}
        </div>
        {!! Form::submit('登録', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif
@endsection