<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // validate data
        $data = $request->validate(
            [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:5'
            ],
            [
                'required' => 'field harus diisi',
                'emai' => 'format tidak sesuai'
            ]
        );
        // creating password hashing by bcrypt
        $data['password'] = bcrypt($request->password);

        // create register user
        $userRegistered = User::create($data);

        // get token
        $tokenizing = $userRegistered->createToken('AuthToken')->accessToken;

        return response()->json([
            'Message' => 'Register Successfully!!!',
            'Data' => $userRegistered['name'],
            'Token' => $tokenizing
        ], 200);
    }

    public function login(Request $request)
    {
        // validate data login
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'required' => 'Field ini harus diisi',
            'email' => 'Format email tidak sesuai'
        ]);

        // user login check
        if (!auth()->attempt($data)) {
            return response()->json(['message' => 'Unauthorization'], 401);
        } else {
            $getToken = auth()->user()->createToken('AuthToken')->accessToken;
            return response()->json([
                'message' => "Congrats, You're logged in!!!",
                'data login' => auth()->user(),
                'token' => $getToken
            ], 200);
        }
    }
}
