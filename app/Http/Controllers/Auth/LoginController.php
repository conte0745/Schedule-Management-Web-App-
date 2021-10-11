<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;

class LoginController extends Controller
{
        /**
     * Googleの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Googleからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $google = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $google->email)->first();
        
        if ($user == null) {
            // $user = User::create([
            //     'name'     => $google->name,
            //     'email'    => $google->email,
            //     'password' => \Hash::make(openssl_random_pseudo_bytes(30)),
            //     'color' => '#fff8dc',
            //     'state' => '設定しない',
            //     'permission' => 0,
            // ]);
        
            // return $user;
            return redirect()->route('notFoundGoogle');
        }
        // ログイン処理
        \Auth::login($user, true);
        return redirect()->route('calendar');
    }
    
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    
    public function email()
    {
        return 'email';
    }
    
    public function loggedOut($request)
    {
         return redirect()->route('top');
    }
}
