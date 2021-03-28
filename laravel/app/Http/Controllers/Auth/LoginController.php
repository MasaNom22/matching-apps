<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     // ゲストユーザー用のメールアドレスを定数として定義
     private const GUEST_USER_EMAIL = 'guest@guest.com';

     // ゲストログイン処理
     public function guestLogin()
     {
         //use Auth; use App\User;が必要
         $user = User::where('email', self::GUEST_USER_EMAIL)->first();
         if ($user) {
             Auth::login($user);
             return redirect('/');
         }
         return redirect('/');
     }
}
