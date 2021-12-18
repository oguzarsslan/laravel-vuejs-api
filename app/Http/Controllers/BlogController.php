<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function storeBlog(Request $request)
    {
        $arg = $request->only('title', 'body', 'category', 'keywords', 'images');

        $rules = [
            'title' => 'required|min:5|max:20',
            'body' => 'required|min:5|max:255',
            'category' => 'required'
        ];

        $validator = Validator::make($arg, $rules);

        if ($validator->fails())
            return response()->json($validator->errors()->first());

        $blog = new Blog();
        $blog->user_id = Auth::id();
        $blog->title = $arg['title'];
        $blog->body = $arg['body'];
        $blog->category = $arg['category'];
        $blog->keywords = $arg['keywords'];
        $blog->seen = 0;
        $blog->save();

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('images'), $name);

                $data = new Image();
                $data->image = $name;
                $data->blog_id = $blog->id;
                $data->save();
            }
        }

        return response()->json($data);
    }

    public function getBlogs()
    {
        $blogs = Blog::orderBy('created_at', 'desc')
            ->with('Images', 'users')
            ->get();

        return response()->json($blogs);
    }

    public function getBlog($id)
    {
        $blog = Blog::with('comments', 'users', 'Images')
            ->find($id);
        $blog->seen += 1;
        $blog->save();

        return response()->json($blog);
    }

    public function updateBlog(Request $request)
    {
        $arg = $request->only('title', 'body', 'category', 'images', 'blogId');

        $rules = [
            'title' => 'required|min:5|max:20',
            'body' => 'required|min:5|max:255',
            'category' => 'required'
        ];

        $validator = Validator::make($arg, $rules);

        if ($validator->fails())
            return response()->json($validator->errors()->first());

        $blog = Blog::find($arg['blogId']);
        $blog->title = $arg['title'];
        $blog->body = $arg['body'];
        $blog->category = $arg['category'];
        $blog->save();

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . rand(1, 100) . '.' . $image->extension();
                $image->move(public_path('images'), $name);

                $data = new Image();
                $data->image = $name;
                $data->blog_id = $blog->id;
                $data->save();
            }
        }

        return response()->json($blog);
    }

    public function deleteBlog(Request $request)
    {
        $arg = $request->only('id');

        $blog = Blog::find($arg['id']);
        $blog->delete();

        $image = Image::where('blog_id', $arg['id']);
        $image->delete();

        return response('ok');
    }

    public function deleteImage(Request $request)
    {
        $arg = $request->only('id');

        $image = Image::find($arg['id']);
        $image->delete();

        return response('the picture was deleted');
    }

//    public function test()
//    {
//        $blogs = DB::table('comments')
//            ->join('users', 'users.id', 'comments.blog_id')
//            ->join('blogs', 'users.id', 'blogs.user_id')
//            ->get();
//
//        return response($blogs);
//    }
}
