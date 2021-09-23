<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Events\MessageCreated;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    
    public function index()
    {
        $group_id = User::find(Auth::id())->group_id;
        
        $pageNum = 10;
        
        $users = User::where('group_id',$group_id)->get()->toArray();
        $chat = Chat::where('group_id',$group_id)->where('init', true)->orderBy('updated_at','DESC')->paginate($pageNum);
        
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($chat),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $chat[$i]['name'] = $name[$chat[$i]['personal_id']];
        }
        
        return $chat;
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
        $chat->parent_id = $chat->id;
        $chat->save();
        event(new MessageCreated($chat));
        return $chat;
    }
    
    public function replyStore(Request $request)
    {
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
        $param = $request->all();
        
        $chat2 = Chat::find($param['init']);
        $chat = new Chat;
        $chat->body = $param['message'];
        $chat->personal_id = $personal_id;
        $chat->group_id = $group_id;
        $chat->parent_id = $param['init'];
        $chat->init = false;
        $chat->save();
        $chat2->child_id = $chat->id;
        $chat2->save();
        event(new MessageCreated($chat));
        return $chat;
    }
    
    public function del(Request $req){
        $param = $req->all();
        Chat::find($param['id'])->forceDelete();
        
    }
    
    public function edit(Request $request)
    {
        $group_id = User::find(Auth::id())->group_id;
        $param = $request->all();
        $pageNum = 10;
       
        $users = User::where('group_id',$group_id)->get()->toArray();
        $chat = Chat::where('parent_id', $param['id'])->orderBy('created_at','DESC')->paginate($pageNum);
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($chat),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $chat[$i]['name'] = $name[$chat[$i]['personal_id']];
        }
        
        return $chat;
    }
}
