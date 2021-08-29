<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $group_id = 1;
        
        $chat = Chat::where('group_id',$group_id)->get();
 
        return $chat;
    }
    
    public function store(Request $request)
    {
        dump($request);
       return view('dm')->with(['test' => $request]);
        
        $personal_id = 1;
        $group_id = 1;
       
        $chat = new Chat;
        $chat->text = $request->input('message');
        $chat->personal_id = $personal_id;
        $chat->group_id = $group_id;
        $chat->save(); 
        
        // Chat::create([
        //     'body' => $request->message,
        //     'personal_id' => $personal_id,
        //     'group_id' => $group_id,
        // ]);
       return $chat;
    }
}
