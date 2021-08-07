@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">業務詳細</h1>
    <table class="table">
        <tr>
            <th>タイトル：</th>
            <td>{{ $task->title }}</td>
        </tr>
        <tr>
            <th>着手日：</th>
            <td>{{ $start_date }}</td>
        </tr>
        <tr>
            <th>納期：</th>
            <td>{{ $deadline }}</td>
        </tr>
        <tr>
            <th>担当者：</th>
            <td>
                @foreach($task_members as $task_member)
                <ul class="mb-0 list-unstyled">
                    <li>{{ $task_member->name }}</li>
                </ul>
                @endforeach
            </td>
        </tr>
        <tr class="border-bottom">
            <th>コメント：</th>
            <td>{!! nl2br(e($task->comment)) !!}</td>
        </tr>
    </table>
    <div>
        {!! link_to_route('editTask.get', '編集', [$task->id], ['class'=>'btn btn-primary mt-2']) !!}
    </div>
    <div>
        {!! Form::open(['route'=>['task.delete', $task->id], 'method'=>'delete']) !!}
            {!! Form::submit('削除', ['class'=>'btn btn-danger mt-2']) !!}
        {!! Form::close() !!}
    </div>
@endif
@endsection