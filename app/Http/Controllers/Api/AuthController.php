<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RegistrarInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var RegistrarInterface
     */
    private $registrar;

    /**
     * AuthController constructor.
     * @param RegistrarInterface $registrar
     */
    public function __construct(RegistrarInterface $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * @param RegisterUser $request
     * @return mixed
     */
    public function register(RegisterUser $request)
    {
        return $this->registrar->register($request);
    }

    /**
     * @param LoginUser $request
     * @return mixed
     */
    public function login(LoginUser $request)
    {
        return $this->registrar->login($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $this->registrar->logout($request);
    }
}
