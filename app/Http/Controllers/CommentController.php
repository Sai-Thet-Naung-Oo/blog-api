<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Gate;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
    //

    public function create()
     {
     $comment = new Comment;
     $comment->content = request()->content;
     $comment->article_id = request()->article_id;
     $comment->user_id = auth()->user()->id;
     $comment->save();
     return back();
     }

     public function delete($id)
     {
     $comment = Comment::find($id);

     if(Gate::denies('comment-delete', $comment)) {
        return back()->with('info', 'Unauthorize'); 
        }
     $comment->delete();
     return back();
     }

}
