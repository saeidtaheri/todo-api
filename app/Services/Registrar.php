<?php

namespace App\Services;

use App\Contracts\RegistrarInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Registrar implements RegistrarInterface {

    protected $model;

    /**
     * Registrar constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $user
     * @return mixed
     */
    protected function generateAccessToken($user)
    {
        $token = $user->createToken($user->email . '-' . now());

        return $token;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($request)
    {
        try {
            $this->model::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json(['Registered successfully, please login'], 201);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($request)
    {
        try {
            if( Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
    
                $success['token'] = $this->generateAccessToken($user)->accessToken;
    
                return response()->json([
                    'success' => $success,
                ], 200);
            }
        }catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }

        return response()->json(['errors'=>'Incorrect email or password!'], 401);
    }

    public function logout($request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'success' => 'You have been successfully logged out!',
        ], 200);
    }
}
