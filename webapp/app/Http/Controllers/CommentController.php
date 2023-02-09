<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{

    public function show($comment_id){
        if (!Comment::exists($comment_id)){
            abort(404);
        }
        return View::make('partials.comment.comment',['comment' => Comment::find($comment_id)]);
    }


    public function delete($comment_id){
        if (!Comment::exists()){
            return response()->json(['error' =>'comment not found']);
        }

        if (Auth::user()->cannot('delete',Comment::class)){
            return response()->json(['error' =>'you cannot edit this comment']);
        }

        $comment = Comment::find($comment_id);
        $comment->owner_id = 1;
        $comment->text = '[deleted]';
        $comment->save();

        return response()->json(['success' =>'comment deleted']);
    }

    /*
     * {
     *      text: string
     * }
    */
    public function edit($comment_id, Request $request){
        $validator = Validator::make($request->all(),['text'=>'required|string|max:2048|min:1']);
        if($validator->fails()){
            return $validator->errors();
        }
        if (!Comment::exists($comment_id)){
            return response()->json(['error' => 'comment not found']);
        }

        $comment = Comment::find($comment_id);
        if (Auth::user()->cannot('update',$comment)){
            return response()->json(['error' => 'you cant edit this comment']);
        }

        $comment->text = $request->text;
        $comment->save();

        return response()->json(['success' => 'comment updated']);
    }

    /*
     * {
     *      postId: Integer,
     *      ParentCommentId: Integer,
     *      text: string
     * }
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'postId' => 'bail|required|integer|exists:post,id',
            'commentId' => 'bail|nullable|integer|exists:comment,id',
            'text' => 'bail|required|string|max:2048|min:1'
        ]);
        if ($validator->fails())
            return $validator->errors();

        $post = Post::find($request->input('postId'));

        if (Auth::user()->cannot('create',[Comment::class,$post]))
            return response()->json(['error' => 'you cannot comment on this post']);

        $comment = Comment::create([
            'owner_id' => Auth::id(),
            'parent_post' => $request->input('postId'),
            'parent_comment' => $request->input('commentId'),
            'text' => $request->input('text')
        ]);

        return response()->json([
            'success' => 'comment created',
            'id' => $comment->id
        ]);
    }
}
