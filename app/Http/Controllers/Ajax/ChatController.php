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
        
        $pageNum = 5;
        
        $users = User::where('group_id',$group_id)->get()->toArray();
        $chat = Chat::where('group_id',$group_id)->where('child_id',null)->orderBy('updated_at','DESC')->paginate($pageNum);
        
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($chat),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $chat[$i]['personal_id'] = $name[$chat[$i]['personal_id']];
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
       
       return $chat;
    }
    
    public function replyStore(Request $request)
    {
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
        $param = $request->all();
        
        $chat2 = Chat::find($pram['message']->id)
    //     $chat = new Chat
    //     $chat->body = $request->input('message');
    //     $chat->personal_id = $personal_id;
    //     $chat->group_id = $group_id;
    //     //$chat->parent_id = $chat2->id;
    //     $chat->save();
       
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
        $pageNum = 5;
        
        $users = User::where('group_id',$group_id)->get()->toArray();
        $chat = Chat::where('id',$param['id'])->where('child_id',null)->orderBy('updated_at','DESC')->paginate($pageNum);
        
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($chat),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $chat[$i]['personal_id'] = $name[$chat[$i]['personal_id']];
        }
        
        return $chat;
    }
}
