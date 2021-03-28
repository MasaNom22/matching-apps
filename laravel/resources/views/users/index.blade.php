@extends('layouts.app')

@section('title', 'ユーザ一覧画面')

@section('content')
<h2>ユーザー一覧画面</h2>

<div class=container>
    <div class=row>
        @foreach($users as $user)
        <div style="" class="col-md-3 mt-4 mb-4">
            <h4>名前: {{ $user->name }}</h4>
	        <h5>年齢: {{ $user->age }}</h5>
	        <h5>性別: {{ $user->gender_label }}</h5>
	        @if(isset($user->uploadimages))
	        <img class="user-icon rounded-circle" src="{{ Storage::url($user->uploadimages->file_path) }}" style="width:100%;"　alt="写真"/>
            @else
            <i class="fas fa-user-circle fa-9x mr-1"></i>
            @endif
            @if( Auth::id() !== $user->id )
            <follow-button
              class="ml-auto"
              :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
              :authorized='@json(Auth::check())'
              endpoint="{{ route('users.follow', ['name' => $user->name]) }}"
            >
            </follow-button>
          @endif
        </div>
        @endforeach
    </div>
</div>
@endsection