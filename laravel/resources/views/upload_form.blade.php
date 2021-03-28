@extends('layouts.app')

@section('title', '画像投稿画面')

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
	<h2>画像登録画面</h2>
	@if(isset($user->uploadimages))
	                <div class="form-group text-center">
	                  <label for="profile_image">
	                    <p class="mb-1">プロフィール画像</p>
	                    <img class="profile-icon image-upload rounded-circle" src="{{ Storage::url($user->uploadimages->file_path) }}" style="width:50%;"　alt="プロフィール画像">
	                    
	                  </label>
	                </div>
	@else
		<form method="post" action="{{ route('upload_image') }}" enctype="multipart/form-data">
		
			@csrf
			
			<div class="form-group row">
				<label for="content" class="col-md-4 col-form-label text-md-right fas fa-arrow-alt-circle-down">{{ __('画像を選択') }}</label>
				<div class="col-md-6">
					<input type="file" name="image" accept="image/png, image/jpeg" />
				</div>
			</div>
			<div class="form-group row">
				<label for="content" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
				<div class="col-md-6">
					<input type="submit" value="写真を保存する">
				</div>
			</div>
		</form>
@endif
@endsection