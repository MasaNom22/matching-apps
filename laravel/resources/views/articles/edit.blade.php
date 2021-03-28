@extends('layouts.app')

@section('title', 'コメント編集画面')

@section('content')
  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-7">
        <div class="card">
          <h2 class="h4 card-header text-center aqua-gradient text-white">コメント編集</h2>
          <div class="card-body pt-3">

            <div class="card-text">
              <form method="POST" class="w-75 mx-auto" action="{{ route('articles.update', ['id' => $article->id]) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                  <label for="body">投稿内容</label>
                <input type="body" class="form-control" name="body" id="body"
                       value="{{ old('body') ?? $article->body }}" />
                </div>

                <button type="submit" class="btn aqua-gradient btn-block">
                  <span class="h6">更新する</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection