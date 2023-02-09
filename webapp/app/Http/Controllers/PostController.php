<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    //todo
    public function delete(){
        return View::make(RouteServiceProvider::HOME);
    }

    //todo
    public function update(){
        return View::make(RouteServiceProvider::HOME);
    }

    //todo
    public function edit(){
        return View::make(RouteServiceProvider::HOME);
    }

    public function get($event_id,$post_id){
        $post = Post::find($post_id);

        if (!isset($post))
            return response()->json(['error' => 'post not found']);

        if (Auth::user()->cannot('show',$post))
            return response()->json(['error' => 'user cannot see this event']);


        return View::make('partials.post.post',['post' => $post]);
    }

    public function create($event_id, Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'text' => 'required|string',
            'option' => 'nullable|json',
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }

        if (!Event::exists($event_id))
            return response()->json(['error' => 'event '.$event_id.' not found']);

        $post = Post::create([
            'owner_id' => Auth::id(),
            'event_id' => $event_id,
            'title' => $request->input('title'),
            'text' => $request->input('text'),
        ]);

        return response()->json([
            'success' => 'post created',
            'id' => $post->id
        ]);

    }

    public function upload($event_id, $post_id, Request $request){
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,gif|max:10000'
        ]);

        $path = $request->file('file')->store('file','public');

        $post = Post::find($post_id);
        $post->file = $path;
        $post->save();
        return response()->json(['path' => $path]);
    }
}
