<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SelectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index() {
        
        $group_id = User::find(Auth::id())->group_id;
        
        if($group_id == -1)
            return  view('auth/select');  
        else
            return redirect()->route('calendar');
    }
    
}
