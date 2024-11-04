<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with("phone")->get();
        return $users;
    }
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please Fill All Field',
                'error' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Registered Successfully',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'please fill all field',
                'error' => $validator->errors()
            ]);
        }

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                'status' => false,
                'message' => 'Wrong Email Or Password'
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('My Api Token')->plainTextToken;

        $authUser = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            'status' => true,
            'message' => 'Login Successfuly',
            'data' => $authUser
        ]);
    }

    public function logout()
    {

        Auth::logout();

        return response()->json([
            'status' => true,
            'message' => 'Logout Successful'
        ]);
    }
}
