@extends('layouts.app')

@section('title', '投稿詳細画面')

@section('content')

<div class="container mt-4">
  <div class="row d-flex justify-content-center">
    <div class="row col-md-12">
      <aside class="col-3 d-none d-md-block position-fixed">
      </aside>
      <main class="col-md-7 offset-md-5">
            @include('articles.card')
        </main>
    </div>
  </div>
</div>	                    

@endsection