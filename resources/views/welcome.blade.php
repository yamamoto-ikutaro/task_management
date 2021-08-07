@extends('layouts.app')

@section('content')

@if(!Auth::check())
    <div class="jumbotron">
        <h2 class="mb-4">このサイトでできること</h1>
        <ul>
            <li>メンバーごとの予定・業務の一覧確認</li>
            <li>メンバーごとの予定・業務の詳細確認</li>
            <li>予定の登録・編集</li>
            <li>資料のアップロード・ダウンロード</li>
            <li>業務の登録・編集</li>
            <li>ToDoリストの追加・編集/リマインドメールの送付</li>
        </ul>
        <div class="text-center">
            {!! link_to_route('signup.get', '会員登録', [], ['class'=>'btn btn-primary']) !!}
        </div>
    </div>
@else
    <h1 class="text-center mb-4">{{ $user->name }}さんのスケジュール</h1>
    <h3 class="text-center mb-4">今日の日付：{{ date('Y/m/d') }}</h3>
    <div class="row">
        <div class="col-sm-8">
            {!! Form::open(['route'=>'topPage','method'=>'get']) !!}
                <div>▼日付で検索</div>
                <div class="form-group input-group">
                    {!! Form::date('calender', null) !!}
                    {!! Form::button('<i class="fas fa-search"></i>', ['class' => "btn input-group-text", 'type' => 'submit']) !!}
                </div>
                @if($errors->first('calender'))
                    <p class="text-danger">{{ $errors->first('calender') }}</p>
                @endif
            {!! Form::close() !!}
            
            {!! link_to_route('scheduleRegister.get', '予定登録', [], ['class'=>'btn btn-primary']) !!}
            {!! link_to_route('taskRegister.get', '業務登録', [], ['class'=>'btn btn-success']) !!}
            
            <div class="text-right">
                {!! link_to_route('topPage', '< 前週', ['calender'=>$calender, 'w'=>$w - 1]) !!}
                {!! link_to_route('topPage', '次週 >', ['calender'=>$calender, 'w'=>$w + 1]) !!}
            </div>
            
            
            <table class="table table-bordered mb-0">
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
                                @if($schedule->users->where('id', Auth::id())->first())
                                @if(date("m/d", strtotime($schedule->date)) == $date)
                                    <ul class="mb-0 list-unstyled">
                                        <li>{!! link_to_route('showSchedule', $schedule->title, [$schedule->id]) !!}</li>
                                    </ul>
                                @endif
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
                                @if($task->users->where('id', Auth::id())->first())
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
                    <tr>
                        @if(!$user->message)
                            <th colspan="7">
                                {!! Form::open(['route' => ['userMessagePut', $user->id], 'method' => 'put']) !!}
                                    {!! Form::label('message', '伝達事項：') !!}
                                    {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                    {!! Form::submit('追加', ['class'=>'btn btn-primary d-block mt-2', 'maxlength' => '3']) !!}
                                {!! Form::close() !!}
                            </th>
                        @elseif($user->message && $query !== "update")
                            <th colspan="7">
                                <p class="mb-0">伝達事項：</p>
                                {!! nl2br(e($user->message)) !!}
                                <!--更新フォーム表示ボタン-->
                                <div class="mt-2">
                                    {!! link_to_route('topPage', '更新しますか？', ['message' => 'update'], ['class' => 'btn btn-primary']) !!}
                                </div>
                                <!--▼削除ボタン-->
                                {!! Form::open(['route' => ['userMessageDelete', $user->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('削除', ['class'=>'btn btn-danger d-block mt-2']) !!}
                                {!! Form::close() !!}
                            </th>
                        @elseif($user->message && $query === "update")
                            <th colspan="7">
                                {!! Form::model($user, ['route' => ['userMessagePut', $user->id], 'method' => 'put']) !!}
                                    {!! Form::label('message', '伝達事項：') !!}
                                    {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                    {!! Form::submit('更新', ['class'=>'btn btn-success d-block mt-2', 'maxlength' => '3']) !!}
                                {!! Form::close() !!}
                            </th>
                        @endif
                    </tr>
            </table>
                
            {!! link_to_route('userInfo.get', 'ユーザー情報を更新する', [$user->id], ['class'=>'btn btn-primary mt-4']) !!}
        </div>
        <div class="col-sm-4">
            <h3 class="pt-4 pl-4 mb-4">ToDoリスト</h3>
            {!! Form::open(['route' => ['todo', $user->id]]) !!}
                <div class="form-group input-group pl-4">
                    {!! Form::text('content', null, ['class'=>'form-control']) !!}
                    {!! Form::button('追加', ['class'=>'btn btn-info', 'type'=>'submit']) !!}
                </div>
            {!! Form::close() !!}
            <ul>
                @foreach($user->todo as $todo)
                    <li>{!! link_to_route('todo_reminder', $todo->content, [$todo->id]) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@endsection