<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterReuqest;
use App\User;

class RegisterController extends Controller
{
    public function register(RegisterReuqest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'ic_number' => $request->input('ic_number'),
            'ic_photo' => $request->input('ic_photo'),
            'password' => bcrypt($request->input('password')),
        ]);

        if (!$user){
            return response()->json(['error'=> 'register failed.'], 400);
        }

        return response()->json([]);
    }
}
