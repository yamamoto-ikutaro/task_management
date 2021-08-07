@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4">更新しました</h1>
    <table class="table">
        <tr>
            <th>氏名：</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email：</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>
                <p>********</p>
            </td>
        </tr>
    </table>
    {!! link_to_route('topPage', 'トップページへ', [], ['class'=>'btn btn-primary']) !!}
@endif
@endsection