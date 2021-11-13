<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(User $user)
    {
        $user = User::find(Auth::id());   
        return view('mypage/index')->with(['user' => $user->toArray()]);
    }
    
    public function edit(User $user)
    {
        $user = User::find(Auth::id());   
        return view('mypage/edit')->with(['user' => $user->toArray()]);
    }

    
    public function update(UserRequest $req)
    {
        $user = User::find(Auth::id());    
        $input = $req['user'];
        $user->name = $input['name'];
        $user->color = $input['color'];
        $user->state = $input['state'];
        $user->save();
        return redirect('/calendar/mypage');        
        
    }
    
    public function del(User $user)
    {
        Auth::logout();
        $user->forceDelete();
        return view('top');
    }
    
}
