<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\ShopperRequest;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    
    protected function new_create(ShopRequest $req,Shop $shop)
    {
        $user = User::find(Auth::id());
        $user->permission = 2;
        $shop->shop = $req['shop'];
        $shop->shop_name = $req['shop'];
        $shop->save();
        $shop->where('shop',$req['shop'])->first();
        $user->group_id = $shop->id;
        $user->save();
        return redirect('/calendar');
    }
    
    protected function already_create(ShopRequest $req,Shop $shop)
    {
        $input = $req['shop_id'];
        $shop = Shop::where('shop',$input)->get()->toArray();
        
        if(count($shop) == 1){
            $user = User::find(Auth::id());
            $user->group_id = $shop[0]['id'];
            $user->save();
        }else{
            return back();
        }
    
        return redirect()->action('CalendarController@index');
    }
    
    public function index()
    {
        if(User::find(Auth::id())->permission == 0){
            return redirect('calendar');
        }
        $user = User::find(Auth::id());
        $shop = Shop::find($user->group_id)->toArray();
        $members = User::select('name','permission','id','state')->where('group_id',$user->group_id)->where('permission',0)->get()->toArray();
        $users = User::select('name','permission','id')->where('group_id',$user->group_id)->where('permission', 1)->get()->toArray();
        $one_user = User::select('name','permission','id')->where('group_id',$user->group_id)->where('permission', 2)->get()->toArray();
        
        return view('root/index')->with(['users' => $users, 'shop'=> $shop,'one_user' => $one_user,'members'=> $members]);
    }

    public function edit(){
        if(User::find(Auth::id())->permission == 0){
            return redirect('calendar');
        }
        $user = User::find(Auth::id());
        $shop = Shop::find($user->group_id)->toArray();
        $members = User::select('name','permission','id','state')->where('group_id',$user->group_id)->where('permission',0)->get()->toArray();
        $users = User::select('name','permission','id')->where('group_id',$user->group_id)->where('permission', 1)->get()->toArray();
        $one_user = User::select('name','permission','id')->where('group_id',$user->group_id)->where('permission', 2)->get()->toArray();
       
        return view('root/edit')->with(['members'=>$members,'users' => $users,'one_user' => $one_user, 'shop'=> $shop]);
    }
    
    public function update(ShopperRequest $req,$id)
    {
        if(User::find(Auth::id())->permission == 0){
            return redirect('calendar');
        }
        
        
        if($req['shop'] == null || $req['shop_name'] == null ){
            return back();
        };
       
        $shop = Shop::find($id);
        $shop->shop_name = $req['shop_name'];
        $shop->shop = $req['shop'];
        $shop->save();
        
        if($req['add_root'] != 'none'){
            $user = User::find($req['add_root']);
            $user->permission = 1;
            $user->save();
            
        }
        if($req['del_root'] != 'none'){
            $user = User::find($req['del_root']);
            $user->permission = 0;
            $user->save();
            
        }
       
        return redirect('calendar/root');
    }
    
}
