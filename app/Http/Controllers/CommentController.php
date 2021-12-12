<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function setComment(Request $request)
    {
        $arg = $request->only('comment', 'user_id', 'blog_id');

        $comment = new Comment();
        $comment->user_id = $arg['user_id'];
        $comment->blog_id = $arg['blog_id'];
        $comment->comment = $arg['comment'];
        $comment->save();

        return response($comment);
    }

    public function upComment(Request $request)
    {
        $arg = $request->only('id', 'comment');

        $comment = Comment::find($arg['id']);
        $comment->comment = $arg['comment'];
        $comment->save();

        return response($comment);
    }

    public function deleteComment(Request $request)
    {
        $arg = $request->only('id');

        $comment = Comment::find($arg['id']);
        $comment->delete();

        return response('ok');
    }
}
