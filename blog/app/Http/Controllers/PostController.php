<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;


class PostController extends Controller
{

    public function show(Post $post)
    {
        return view('show') -> with(['datas' => $post ->get()]);
    }
    
   
}
