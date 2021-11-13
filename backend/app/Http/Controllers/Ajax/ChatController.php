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
        $msg = Chat::where('group_id',$group_id)->where('init', true)->orderBy('updated_at','DESC')->paginate($pageNum);
        
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($msg),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $msg[$i]['name'] = $name[$msg[$i]['personal_id']];
        }
        
        return $msg;
    }
    
    
    public function store(Request $request)
    {
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
       
        $msg = new Chat;
        $msg->body = $request->input('message');
        $msg->personal_id = $personal_id;
        $msg->group_id = $group_id;
        $msg->save(); 
        $msg->parent_id = $msg->id;
        $msg->save();
        broadcast(new MessageCreated($msg))->toOthers();
        return $msg;
    }
    
    public function replyStore(Request $request)
    {
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
        $param = $request->all();
        
        $msg2 = Chat::find($param['init']);
        $msg = new Chat;
        $msg->body = $param['message'];
        $msg->personal_id = $personal_id;
        $msg->group_id = $group_id;
        $msg->parent_id = $param['init'];
        $msg->init = false;
        $msg->save();
        $msg2->child_num += 1;
        $msg2->save();
        broadcast(new MessageCreated($msg))->toOthers();
        
        return $msg;
    }
    
    public function del(Request $req){
        $param = $req->all();
        $msg = Chat::find($param['id']);
        $parentMsg = Chat::find($msg->parent_id);
        $parentMsg->child_num -= 1;
        $parentMsg->save();
        broadcast(new MessageCreated($msg))->toOthers();
        $msg->forceDelete();
        
    }
    
    public function edit(Request $request)
    {
        $group_id = User::find(Auth::id())->group_id;
        $param = $request->all();
        $pageNum = 10;
       
        $users = User::where('group_id',$group_id)->get()->toArray();
        $msg = Chat::where('parent_id', $param['id'])->orderBy('created_at','DESC')->paginate($pageNum);
        
        $name = [];
        foreach($users as $user){
            $name += array($user['id'] => $user['name']);
        } 
        
        $count = min(count($msg),$pageNum);
        
        for($i=0; $i<$count; $i++){
            $msg[$i]['name'] = $name[$msg[$i]['personal_id']];
        }
        
        return $msg;
    }
}
