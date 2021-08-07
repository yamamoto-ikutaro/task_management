@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">更新しました</h1>
    <table class="table">
        <tr>
            <th>タイトル：</th>
            <td>{{ $task->title }}</td>
        </tr>
        <tr>
            <th>納期：</th>
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
    <div class=" mb-4">
        {!! link_to_route('topPage', 'トップページへ', [], ['class'=>'btn btn-primary']) !!}
    </div>
@endif
@endsection