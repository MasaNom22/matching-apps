@if (Auth::user()->is_liking($article->id))
        {{-- unfavoriteボタンのフォーム --}}
        {!! Form::open(['route' => ['articles.unlike', $article], 'method' => 'delete']) !!}
            <!--{!! Form::submit('いいねを外す', ['class' => "btn btn-danger "]) !!}-->
            {!! Form::button('<i class="fas fa-heart">いいねを外す</i>', ['class' => "btn btn-danger", 'type' => 'submit']) !!}
        {!! Form::close() !!}
    @else
        {{-- favoriteボタンのフォーム --}}
        {!! Form::open(['route' => ['articles.like', $article]]) !!}
            <!--{!! Form::submit('いいね', ['class' => "far fa-heart"]) !!}-->
            {!! Form::button('<i class="fas fa-heart">いいね</i>', ['class' => "btn btn-danger ", 'type' => 'submit']) !!}
        {!! Form::close() !!}
    @endif