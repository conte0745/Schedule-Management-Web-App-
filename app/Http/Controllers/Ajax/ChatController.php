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
        
        $chat = new Chat; 
        $chat->where('group_id',$group_id)->get();
        
        return $chat;
    }
    
    public function store(Request $req)
    {
        $group_id = 1;
        $personal_id = 1;
        
        
        Chat::create([
            'group_id' => $group_id,
            'personal_id' => $personal_id,
            'text' => $req['text'],
        ]);
        
        
        
    }
}
