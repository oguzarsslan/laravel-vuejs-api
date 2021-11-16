<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get()
    {
        $users = User::all();

        return response($users);
    }

    public function store(Request $request)
    {
        $arg = $request->only('email', 'password');

        $user = new User();
        $user->name = 1;
        $user->email = $arg['email'];
        $user->password = bcrypt($arg['password']);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function delete(Request $request)
    {
        $arg = $request->only('id');

        $user = User::find($arg['id']);
        $user->delete();

        return response('kayıt silindi');
    }

    public function login(Request $request)
    {
        $arg = $request->only('email', 'password');

        if (!auth()->attempt($arg)) {
            return response('başarısız');
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
