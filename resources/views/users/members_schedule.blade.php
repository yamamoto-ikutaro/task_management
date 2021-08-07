@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">メンバースケジュール一覧</h1>
    <div class="row">
        @if($users->isEmpty())
        <div class="col-sm-8">
            <div class="jumbotron text-center">
                予定\業務を確認するメンバーを追加してください。
            </div>
        </div>
        @else
        <div class="col-sm-8">
                {!! Form::open(['route'=>'members_schedule', 'method'=>'get']) !!}
                    {!! Form::label('calender', '▼日付で検索') !!}
                    <div class="form-group input-group">
                        {!! Form::date('calender', null) !!}
                        {!! Form::button('<i class="fas fa-search"></i>', ['class' => "btn input-group-text", 'type' => 'submit']) !!}
                    </div>
                    @if($errors->first('calender'))
                        <p class="text-danger">{{ $errors->first('calender') }}</p>
                    @endif
                {!! Form::close() !!}
                
                {!! link_to_route('scheduleRegister.get', '予定登録', ['members_schedule'], ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('taskRegister.get', '業務登録', ['members_schedule'], ['class'=>'btn btn-success']) !!}
                
                <div class="text-right">
                    {!! link_to_route('members_schedule', '< 前週', ['calender'=>$calender,'w'=>$w - 1]) !!}
                    {!! link_to_route('members_schedule', '次週 >', ['calender'=>$calender,'w'=>$w + 1]) !!}
                </div>
                
                @foreach($users as $user)
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th colspan="7" class="text-center">{{ $user->name }}</th>
                        </tr>
                        <tr class="text-center">
                        @foreach($dates as $date)
                            @if(date('w', strtotime($date)) == 0)
                                <th>{{ $date }}<font color='red'>{{ $week[date('w', strtotime($date))] }}</font></th>
                            @elseif(date('w', strtotime($date)) == 6)
                                <th>{{ $date }}<font color='blue'>{{ $week[date('w', strtotime($date))] }}</font></th>
                            @else
                                <th>{{ $date }}{{ $week[date('w', strtotime($date))] }}</th>
                            @endif
                        @endforeach
                        </tr>
                        <tr>
                            <th class="bg-primary p-0 text-white" colspan="7">予定</th>
                        </tr>
                        <tr>
                        @foreach($dates as $date)
                        　　<td class="p-0">
                                @foreach($schedules as $schedule)
                                    @if($schedule->users->where('id', $user->id)->first() && date("m/d", strtotime($schedule->date)) == $date)
                                        <ul class="mb-0 list-unstyled">
                                            <li>{!! link_to_route('showSchedule', $schedule->title, [$schedule->id]) !!}</li>
                                        </ul>
                                    @endif
                                @endforeach
                        　　</td>
                        @endforeach
                        </tr>
                        <tr>
                            <th class="bg-success p-0 text-white" colspan="7">業務</th>
                        </tr>
                        <tr>
                        @foreach($dates as $date)
                        　　<td class="p-0">
                                @foreach($tasks as $task)
                                    @if($task->users->where('id', $user->id)->first())
                                    @if(date("m/d", strtotime($task->start_date)) <= $date && date("m/d", strtotime($task->deadline)) >= $date && date('w', strtotime($date)) !== "0" && date('w', strtotime($date)) !== "6")
                                        <ul class="mb-0 list-unstyled">
                                            <li>{!! link_to_route('showTask', $task->title, [$task->id]) !!}</li>
                                        </ul>
                                    @endif
                                    @endif
                                @endforeach
                        　　</td>
                        @endforeach
                        </tr>
                        <th colspan="7">
                            <p class="mb-0">伝達事項：</p>
                            {!! nl2br(e($user->message)) !!}
                        </th>
                    </table>
                    {!! Form::open(['route' => ['checking_users_delete', $user->id], 'method' => 'delete']) !!}
                        {!! Form::submit('削除', ['class' => 'btn btn-danger mt-1'])!!}
                    {!! Form::close() !!}
                @endforeach
        </div>
        @endif
        <div class="col-sm-4">
        @if(!$users->isEmpty())
            <div style="height:140px;"></div>
        @endif
            {!! Form::open(['route'=>'members_schedule','method'=>'get']) !!}
                <div>▼氏名でメンバー検索</div>
                <div class="form-group input-group">
                    {!! Form::text('keyword', null) !!}
                    {!! Form::button('<i class="fas fa-search"></i>', ['class' => "btn input-group-text", 'type' => 'submit']) !!}
                </div>
                @if($errors->first('keyword'))
                    <p class="text-danger">氏名は必ず入力してください。</p>
                @endif
            {!! Form::close() !!}
            @if($search_result !== 'not_serched' && !$search_result->isEmpty())
            {!! Form::open(['route' => 'checking_users_add']) !!}
                    @foreach($search_result as $user)
                    <div>
                        {{ Form::radio('check', $user->id, false, ['id' => $user->id]) }}
                        <label for = {{ $user->id }}>{{ $user->name }}</label>
                    </div>
                    @endforeach
                {!! Form::submit('追加') !!}
            {!! Form::close() !!}
                @if($errors->first('check'))
                    <p class="text-danger">{{ $errors->first('check') }}</p>
                @endif
            @endif
            @if($search_result !== 'not_serched')
                @if($search_result->isEmpty())
                    <p class="text-danger">該当するメンバーがいません</p>
                @endif
            @endif
        </div>
    </div>
@endif
@endsection