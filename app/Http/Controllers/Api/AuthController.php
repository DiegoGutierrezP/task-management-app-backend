<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->save();

        return response($user,Response::HTTP_CREATED);
    }

    public function login(AuthLoginRequest $request){

        if(Auth::attempt($request->all())){
            $user = Auth::user();
            $token = $user->createToken("auth_token")->plainTextToken;
            //$cookie = cookie('cookie_token',$token,60*24);
            //return response(['user'=>$user,'token'=>$token],Response::HTTP_OK)->withoutCookie($cookie);
            return response(['user'=>$user,'token'=>$token],Response::HTTP_OK);
        }

        return response(['msg'=>'Invalid Credentials'],Response::HTTP_UNAUTHORIZED);

    }

    public function logout(){

        Auth::user()->tokens()->delete();

        return response(['msg'=>'Logout'],Response::HTTP_OK);

    }
}
