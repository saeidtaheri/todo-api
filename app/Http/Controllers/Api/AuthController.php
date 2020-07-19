<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use App\Services\Registrar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Registrar $registrar, RegisterUser $request)
    {
        return $registrar->register($request);
    }

    public function login(Registrar $registrar, LoginUser $request)
    {
        return $registrar->login($request);
    }

    public function logout(Registrar $registrar, Request $request)
    {
        return $registrar->logout($request);
    }
}
