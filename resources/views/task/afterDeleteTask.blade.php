@extends('layouts.app')

@section('content')
@if(Auth::check())
    <h1 class="text-center mb-4 text-danger">削除しました</h1>
    <div class="text-center mb-4">
        {!! link_to_route('topPage', 'トップページへ', [], ['class'=>'btn btn-primary']) !!}
    </div>
@endif
@endsection