<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Multicaret\Acquaintances\Models\Friendship;

class UserController extends Controller
{
    public function get()
    {
        $users = User::all();
        $user = auth()->user();

//        foreach ($users as $item) {
//           echo $item->getAllFriendships();
//        }

        foreach ($users as $item) {
            $a = $user->getFriendship($item);

            if (isset($a['status'])) {
                $item['status'] = $a['status'];
                $item['sender_id'] = $a['sender_id'];
            }
        }

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $arg = $request->only('email', 'password');

        $rules = [
            'email' => 'required|unique:users',
            'password' => 'required|min:2|max:10'
        ];

        $validator = Validator::make($arg, $rules);

        if ($validator->fails())
            return response()->json($validator->errors()->first());

        $user = new User();
        $user->name = 1;
        $user->email = $arg['email'];
        $user->password = bcrypt($arg['password']);
        $user->save();

//        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json('Registration Successful');
    }

    public function delete(Request $request)
    {
        $arg = $request->only('id');

        $user = User::find($arg['id']);
        $user->delete();

        $friendRequest = Friendship::where('sender_id', $arg['id'])->orWhere('recipient_id', $arg['id'])->get();
        foreach ($friendRequest as $item){
            $item->delete();
        }

        return response('kayıt silindi');
    }

    public function login(Request $request)
    {
        $arg = $request->only('email', 'password');

        if (!auth()->attempt($arg)) {
            return response()->json("Failed Login");
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'You have successfully logged out and the token was successfully deleted']);
    }

    public function getUser()
    {
        $authUser = auth()->user()->with('Images')->first();

        return response()->json($authUser);
    }

    public function updateUser(Request $request)
    {
        $arg = $request->only('name', 'email', 'image', 'id');
        $id = $arg['id'];

        $rules = [
            'name' => 'required|min:2|max:10',
            'email' => 'required'
        ];

        $validator = Validator::make($arg, $rules);

        if ($validator->fails())
            return response()->json($validator->errors()->first());

        $user = User::find($arg['id']);
        $user->name = $arg['name'];
        $user->email = $arg['email'];
        $user->save();

        if ($request->hasfile('image')) {
            $name = time() . rand(1, 100) . '.' . $arg['image']->extension();
            $arg['image']->move(public_path('images'), $name);

            $data = Image::where('user_id', $arg['id'])->first();
            if ($data == null) {
                $data = new Image();
                $data->image = $name;
                $data->user_id = $arg['id'];
                $data->save();
            } else {
                $data->image = $name;
                $data->user_id = $arg['id'];
                $data->update();
            }
        }

        return response()->json($user);
    }

    public function friends(Request $request)
    {
        dd($request);
    }
}
