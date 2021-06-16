<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;


class PostController extends Controller
{
    public function index(Post $post)
    {
        //$datas = $post->latest()->get();
        // https://blog.capilano-fw.com/?p=665#latest
        
        return view('index')->with(['datas' => $post ->getPaginateByLimit(5)]);
        // https://qiita.com/ryo2132/items/63ced19601b3fa30e6de
    }
    public function show(Post $post)
    {
        return view('show')->with(['data' => $post]);   
    }
    
   
}
