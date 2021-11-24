<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function storeBlog(Request $request)
    {
        $arg = $request->only('title', 'body', 'category', 'images');

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

//        if ($request->hasfile('images')) {
//            foreach ($request->file('images') as $image) {
                $name = time() . rand(1, 100) . '.' . $request->file('images')->extension();
                $request->file('images')->move(public_path('images'), $name);

                $data = new Image();
                $data->image = $name;
                $data->blog_id = $blog->id;
                $data->save();
//            }
//        }

        return response()->json($data);
    }
}
