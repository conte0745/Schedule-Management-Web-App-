<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use App\Models\User;

class LineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index(Request $reqest)
    {
        return view('line');
    }

    public function redirectToProvider()
    {
        $token = session_id();
        $csrf = Hash::make($token);
        
        $uri = 'https://notify-bot.line.me/oauth/authorize?' .
            'response_type=code' . '&' .
            'client_id=' . config('services.line_notify.client_id') . '&' .
            'redirect_uri=' . config('services.line_notify.redirect_uri') . '&' .
            'scope=notify' . '&' .
            'state=' . $csrf . '&' .
            'response_mode=form_post';
            
        return redirect($uri);
    }

    public function handleProviderCallback(Request $request)
    {
        $id = 1;
        $token = session_id();
        $csrf = Hash::make($token);
        $param = $request->all();

        $uri = 'https://notify-bot.line.me/oauth/token';
        $client = new Client();
        $response = $client->post($uri, [
            'headers'     => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'code'          => $param['code'],
                'redirect_uri'  => config('services.line_notify.redirect_uri'),
                'client_id'     => config('services.line_notify.client_id'),
                'client_secret' => config('services.line_notify.secret')
            ]
        ]);
        
        $access_token = json_decode($response->getBody())->access_token;
        
        $user = User::find($id);
        $user->line = $access_token;
        $user->save();
        dd($user);
        return view('line');
        return redirect()->route('calendar.line');
    }

    public function send()
    {
        $user = User::find(auth::id());
        $access_token = $user->line;
        
        $uri = 'https://notify-api.line.me/api/notify';
        $client = new Client();
        $client->post($uri, [
            'headers' => [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'form_params' => [
                'message' => request('message', 'Hello World!!')
            ]
        ]);
        return redirect()->route('calendar.line');
    }
    
    public function lift()
    {
        $user = User::find(auth::id());
        $access_token = $user->line;
        
        $uri = 'https://notify-api.line.me/api/revoke';
        $client = new Client();
        $client->post($uri, [
            'headers' => [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $access_token,
            ],
            
        ]);
        
        $user->line = null;
        $user->save();
        
        return redirect()->route('calendar.line');
    }
}
