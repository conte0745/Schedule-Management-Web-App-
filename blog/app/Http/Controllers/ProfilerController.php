<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Profiler;
use App\Http\Requests\ProfilerRequest;
use Illuminate\Support\Facades\Auth;

class ProfilerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Profiler $profile)
    {
        
        return view('mypage/index')->with(['profile' => $profile]);
       
    }
    public function show()
    {
        //
    }
    public function edit()
    {
        //
    }
    
    public function create()
    {
        //
    }
    
    public function store(Profiler $profile,ProfilerRequest $req)
    {
        $input = $req['profile'];
        $profile->fill($input)->save();
        return redirect('/calendar/mypage');        
        
    }
    
    
    public function update(ProfilerRequest $req,$id)
    {
        $profile = Profile::find($id);
        
        $input = $req['profile'];
        $Profile->fill($input)->save();
        return redirect('calendar/myapge');
    }
    
    public function del(Profiler $profile)
    {
        $profile->delete();
        return back();
    }
    
}
