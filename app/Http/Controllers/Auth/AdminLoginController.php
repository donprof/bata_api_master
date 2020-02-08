<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function action(LoginRequest $request)
    {
        config()->set( 'auth.defaults.guard', 'admin' );
        Config::set('jwt.user', 'App\Admin'); 
        Config::set('auth.providers.users.model', \App\Models\Admin\Admin::class);
        $token = null;

        if (!$token = auth()->attempt(['email' => $request->email, 'password' => $request->password, 'accountstatus' => 1])) {
            return response()->json([
                'errors' => [
                    'email' => ['Could not sign you in with those details.']
                ]
            ], 422);
        }

        return response()->json([
                'token' => $token,
                'user' => $request->user(),
        ]);
    }

    public function logout()
    {
        auth()->logout();
    }
}
