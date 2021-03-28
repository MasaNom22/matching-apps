@extends('layouts.app')

@section('title', 'マッチング一覧画面')

@section('content')
<h2>マッチング一覧画面</h2>
<div class=container>
    <div class=row>
        @foreach ($users as $user)
            @if(in_array($user->id,Auth::user()->follow_each()))
            <div style="" class="col-md-3 mt-4 mb-4">
                <h4>名前: {{ $user->name }}</h4>
                <h5>年齢: {{ $user->age }}</h5>
                <h5>性別: {{ $user->gender_label }}</h5>
                @if(isset($user->uploadimages))
                <img src="{{ Storage::url($user->uploadimages->file_path) }}" style="width:100%;" alt="写真"/>
                @else
                <i class="fas fa-user-circle fa-9x mr-1"></i>
                @endif
            </div>
            @endif
@endforeach
    </div>
</div>
@endsection
