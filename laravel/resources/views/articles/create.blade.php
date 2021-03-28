@extends('layouts.app')

@section('title', 'コメント投稿画面')

@section('content')
  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center aqua-gradient text-white">メッセージを投稿する</h2>
          <div class="card-body pt-3">
            <div class="text-center mt-3">
            
            
            </div>

            <div class="card-text">
              <!-- 投稿のフォーム -->
              <form id="nomal-post" method="POST" class="w-75 mx-auto" action="{{ route('articles.store') }}">

                @csrf
                <div class="form-group">
                  <label></label>
                  <textarea name="body" class="form-control" rows="8" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
                </div>

              </form>

              <div class="w-75 mx-auto d-flex justify-content-between align-items-start">
                <!-- 通常の投稿ボタン -->
                <div style="width:45%">
                  <button form="nomal-post" type="submit" class="btn btn-block aqua-gradient" >
                    <span class="h6">投稿する</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection