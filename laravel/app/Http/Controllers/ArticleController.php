<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    public function index()
    {
        // 認証済みユーザを取得
        // $user_gender = \Auth::user()->gender;
        // $users = User::where('gender', '!=', $user_gender)->get();
        // $articles = Article::whereIn('user_id',$follows)
        $articles = Article::all()->sortByDesc('created_at');
        // タスク一覧ビューでそれを表示
        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show($id)
    {

        $article = Article::find($id);
        // タスク一覧ビューでそれを表示
        return view('articles.show', [
            'article' => $article,
        ]);
    }

    public function create()
    {
        //use Illuminate\Support\Facades\Auth;が必要
        $user = Auth::user();

        return view('articles.create', [
            'user' => $user,
        ]);
    }

    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->body = $request->body;
        $article->user_id = $request->user()->id;
        $article->save();

        return redirect()->route('articles.index');

    }

    public function edit($id)
    {
        $article = Article::find($id);

        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    public function update($id, Request $request)
    {
        $article = Article::find($id);
        $request->validate([
            'body' => 'required',
        ]);
        $article->body = $request->body;
        $article->save();

        return redirect()->route('articles.index');

    }

    public function destroy($id)
    {
        $deleteArticle = Article::find($id);
        $deleteArticle->delete();

        return redirect()->route('articles.index');
    }

//     public function like($id)
//     {
//          \Auth::user()->like($id);

//         return back();
//     }
    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    // public function unlike($id)
    // {
    //     \Auth::user()->unlike($id);
    //     // 前のURLへリダイレクトさせる
    //     return back();
    // }
    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
