<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class LineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index()
    {
        return view('line_notify.index');
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
        // この環境DBとか入れてないんでとりあえずセッションに入れときます
        $access_token = json_decode($response->getBody())->access_token;
        \Session::set('access_token', $access_token);
        return redirect()->route('calendar.line');
    }

    public function send()
    {
        $uri = 'https://notify-api.line.me/api/notify';
        $client = new Client();
        $client->post($uri, [
            'headers' => [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . session('access_token'),
            ],
            'form_params' => [
                'message' => request('message', 'Hello World!!')
            ]
        ]);
        return redirect()->route('calendar.line');
    }
}
