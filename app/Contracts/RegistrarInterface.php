<?php

namespace App\Contracts;


use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;

interface RegistrarInterface
{
    public function register(RegisterUser $request);
    public function login(LoginUser $request);
    public function logout($request);
}
