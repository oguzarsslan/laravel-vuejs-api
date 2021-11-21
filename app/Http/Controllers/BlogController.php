<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function storeBlog(Request $request)
    {
        $arg = $request->only('title', 'body', 'category');

        $rules = [
            'title' => 'required|min:2',
            'body' => 'required|max:255',
            'category' => 'required'
        ];

        $validator = Validator::make($arg, $rules);

        if ($validator->fails())
            return response()->json($validator->errors()->first());

        $blog = new Blog();
        $blog->title = $arg['title'];
        $blog->body = $arg['body'];
        $blog->category = $arg['category'];
        $blog->save();

        return response()->json($blog);
    }
}
