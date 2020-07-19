<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\User;

class Registrar {

    /**
     * @param $user
     * @return mixed
     */
    protected function generateAccessToken($user)
    {
        $token = $user->createToken($user->email . '-' . now())->accessToken;

        return $token;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($request)
    {
        if( Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $success['token'] = $this->generateAccessToken($user);

            return response()->json([
                'success' => $success,
            ], 200);
        }

        return response()->json(['error'=>'Unauthorized!'], 401);
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
