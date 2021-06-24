<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    public function index(Post $post)
    {
        //$datas = $post->latest()->get();
        // https://blog.capilano-fw.com/?p=665#latest
        
        return view('index')->with(['datas' => $post ->getPaginateByLimit()]);
        // https://qiita.com/ryo2132/items/63ced19601b3fa30e6de
    }
    public function show(Post $post)
    {
        return view('show')->with(['data' => $post]);   
    }
    public function edit(Post $post)
    {
        return view('edit')->with(['data' => $post]);
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(PostRequest $req)
    {
        $post = new Post;
        
        $input = $req['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);        
        
    }
    
    
    public function update(PostRequest $req,Post $post)
    {
        $input = $req['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);   
    }
    
   
}
