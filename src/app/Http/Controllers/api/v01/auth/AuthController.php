<?php

namespace App\Http\Controllers\api\v01\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);
       resolve(AuthRepository::class)->create($request);

        return response()->json([
            'message' => 'create'
        ],201);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            return response()->json([
                'message' => 'successfuly login',
                'user' => Auth::user()
            ],200);
        }

    }
    public function logout(){
        Auth::logout();
        return response()->json([
            'message' => 'user logout successfuly'
        ],200);
    }
}
