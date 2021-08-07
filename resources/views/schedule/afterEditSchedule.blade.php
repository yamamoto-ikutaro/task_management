@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">更新しました</h1>
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
    <div class=" mb-4">
        {!! link_to_route('topPage', 'トップページへ', [], ['class'=>'btn btn-primary']) !!}
    </div>
@endif
@endsection