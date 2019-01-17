<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterReuqest;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->request->add([
            'username' => $request->get('email'),
            'password' => $request->get('password'),
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $dispatch = \Route::dispatch($proxy);

        return $dispatch;
    }

    public function register(RegisterReuqest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json([]);
    }
}
