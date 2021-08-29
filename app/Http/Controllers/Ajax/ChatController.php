<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    
    public function index()
    {
        $group_id = User::find(Auth::id())->group_id;
        
        $users = User::where('group_id',$group_id)->get()->toArray();
        $chat = Chat::where('group_id',$group_id)->get()->toArray();
        
        
        $num = count($chat);
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        
        $message = [];
        for($i=0; $i<$num; $i++){
            $message[] = [
                'name' => $name[$chat[$i]['personal_id']],
                'message' => $chat[$i]['body'],
                'create' => $chat[$i]['created_at'],
                //'parent' => $chat[$i]['parent_id'],
            ];
        }
        
        return $message;
    }
    
    public function store(Request $request)
    {
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
       
        $chat = new Chat;
        $chat->body = $request->input('message');
        $chat->personal_id = $personal_id;
        $chat->group_id = $group_id;
        $chat->save(); 
       
       return $chat;
    }
}
