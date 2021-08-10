<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShopRequest;

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
    
    public function index(){
        $user = User::find(Auth::id());
        $shop = Shop::find($user->group_id)->toArray();
        $user = User::select('name')->where('group_id',$user->group_id);
        $members = $user->where('permission', 0)->get()->toArray();
        $users = $user->where('permission', 1)->get()->toArray();
        $one_user = $user->where('permission', 2)->first();
        
        return view('root/index')->with(['users' => $users, 'shop'=> $shop,'one_user' => $one_user,'members'=> $members]);
    }

    public function edit(){
        $user = User::find(Auth::id());
        $shop = Shop::find($user->group_id)->toArray();
        $members = User::select('name','permission','id')->where('group_id',$user->group_id)->where('permission',0)->get();
        $one_user = $members->where('permission', 2)->toArray();
        $users = $members->where('permission', 1)->toArray();
        return view('root/edit')->with(['members'=>$members->toArray(),'users' => $users,'one_user' => $one_user, 'shop'=> $shop]);
    }
    
    public function update(ShopRequest $req,$id)
    {
       
        $shop = Shop::find($id);
        $shop->shop_name = $req['shop.name'];
        $shop->shop = $req['shop.shop'];
        $shop->save();
        $user = User::find($req['shop.add_root']);
        if($user != null){
            $user->permission = 1;
            $user->save();
        }
        $user = User::find($req['shop.del_root']);
        if($user != null){
            $user->permission = 0;
            $user->save();
        }
       
        return redirect('calendar/root');
    }
    
}
