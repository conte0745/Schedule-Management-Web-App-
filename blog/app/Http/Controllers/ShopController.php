<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index()
    {
        return view('auth/select');
    }
    
    public function store($shop)
    {
        $Shop = new Shop;
        $Shop->shop = $shop;
        $Shop->save();
        
        return view('calendar');
    }
}
