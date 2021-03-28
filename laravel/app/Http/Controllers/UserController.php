<?php

namespace App\Http\Controllers;

use App\Article;
use App\UploadImage;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::All();
        return view('users.index', [
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        $articles = Article::where('user_id', $id)->get();
        // ユーザの投稿数を取得
        $user->loadCount('articles');
        // ユーザのフォロワーをカウント
        $user->loadCount('followers');
        // ユーザのフォローユーザーを取得
        $user->loadCount('followings');

        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_id = $id;
        //アップロードした画像を取得
        $upload = UploadImage::find($user_id);

        return view('users.edit', [
            'user' => $user,
            'image' => $upload,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //ユーザーを特定
        $user = User::find($id);
        $user_id = $id;
        //アップロードした画像を取得
        $upload = UploadImage::find($user_id);
        //ユーザーの上書き
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->save();
        return redirect()->route('users.show', [
            'user' => $user,
            "image" => $upload,
            'id' => $user->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //  public function follow($id)
    // {
    //     // 認証済みユーザ（閲覧者）が、 idのユーザをフォローする
    //     \Auth::user()->follow($id);
    //     // 前のURLへリダイレクトさせる
    //     // return back();
    //     $users=User::All();
    //     return view('users.index', [
    //         "users" => $users,
    //         ]);
    // }
    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['id' => $user->id];
    }
    // public function unfollow($id)
    // {
    //     // 認証済みユーザ（閲覧者）が、 idのユーザをアンフォローする
    //     \Auth::user()->unfollow($id);
    //     // 前のURLへリダイレクトさせる
    //     // return back();
    //     $users=User::All();
    //     return view('users.index', [
    //         "users" => $users,
    //         ]);
    // }

    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['id' => $user->id];
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        // ユーザのフォローユーザーをカウント
        $user->loadCount('followings');
        // ユーザのフォローユーザーを取得
        $followings = $user->followings()->get();

        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        // ユーザのフォロワーをカウント
        $user->loadCount('followers');

        // ユーザのフォロワーを取得
        $followers = $user->followers()->get();

        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }

    public function follow_each($id)
    {
        $user = User::find($id);
        $users = User::All();
        //相互フォロー中のユーザを返す
        return view('users.matchings', [
            'user' => $user,
            "users" => $users,
        ]);
    }
}
