<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\User;

class LineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index()
    {
        return view('line');
    }

    public function redirectToProvider()
    {
        $uri = 'https://notify-bot.line.me/oauth/authorize?' .
            'response_type=code' . '&' .
            'client_id=' . config('services.line_notify.client_id') . '&' .
            'redirect_uri=' . config('services.line_notify.redirect_uri') . '&' .
            'scope=notify' . '&' .
            'state=' . csrf_token() . '&' .
            'response_mode=form_post';
        return redirect($uri);
    }

    public function handleProviderCallback()
    {
        $uri = 'https://notify-bot.line.me/oauth/token';
        $client = new Client();
        $response = $client->post($uri, [
            'headers'     => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'code'          => request('code'),
                'redirect_uri'  => config('services.line_notify.redirect_uri'),
                'client_id'     => config('services.line_notify.client_id'),
                'client_secret' => config('services.line_notify.secret')
            ]
        ]);
        
        $access_token = json_decode($response->getBody())->access_token;
        
        $user = User::find(auth::id());
        $user->line = $access_token;
        $user->save();
        
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
