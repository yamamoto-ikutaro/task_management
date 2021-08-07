@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">予定詳細</h1>
    <div>
        @if($schedule->file_url)
            {!! link_to_route('download', '資料ダウンロード', [$schedule->id], ['class'=>'btn btn-success mb-2']) !!}
        @endif
    </div>
    <table class="table">
        <tr>
            <th>タイトル：</th>
            <td>{{ $schedule->title }}</td>
        </tr>
        <tr>
            <th>日付：</th>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <th>メンバー：</th>
            <td>
                @foreach($members as $member)
                <ul class="mb-0 list-unstyled">
                    <li>{{ $member->name }}</li>
                </ul>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>開始時刻：</th>
            <td>{{ $startTime }}</td>
        </tr>
        <tr>
            <th>終了時刻：</th>
            <td>{{ $endTime }}</td>
        </tr>
        <tr>
            <th>資料名：</th>
            <td>{{ basename($schedule->file_url) }}</td>
        </tr>
        <tr class="border-bottom">
            <th>コメント：</th>
            <td>{!! nl2br(e($schedule->comment)) !!}</td>
        </tr>
    </table>
    <div>
        {!! link_to_route('editSchedule.get', '編集', [$schedule->id], ['class'=>'btn btn-primary mt-2']) !!}
    </div>
    <div>
        {!! Form::open(['route'=>['schedule.delete', $schedule->id], 'method'=>'delete']) !!}
            {!! Form::submit('削除', ['class'=>'btn btn-danger mt-2']) !!}
        {!! Form::close() !!}
    </div>
@endif
@endsection