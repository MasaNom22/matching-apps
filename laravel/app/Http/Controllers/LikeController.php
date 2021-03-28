<?php

namespace App\Http\Controllers;

use App\User;

class LikeController extends Controller
{
    public function index()
    {
        // 認証済みユーザを取得
        $user = \Auth::user();

        $articles = $user->likes()->orderBy('created_at', 'desc')->paginate(5);

        return view('likes.index', [
            'articles' => $articles,
        ]);
    }
}
