<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RegistrarInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $registrar;

    public function __construct(RegistrarInterface $registrar)
    {
        $this->registrar = $registrar;
    }

    public function register(RegisterUser $request)
    {
        return $this->registrar->register($request);
    }

    public function login(LoginUser $request)
    {
        return $this->registrar->login($request);
    }

    public function logout(Request $request)
    {
        return $this->registrar->logout($request);
    }
}
