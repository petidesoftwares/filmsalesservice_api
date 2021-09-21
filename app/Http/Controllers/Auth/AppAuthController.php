<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppAuthController extends Controller
{
    use AuthenticatesUsers;
    protected $guardName;

    protected function guard()
    {
        return Auth::guard($this->guardName);
    }

    public function __construct($guardName){
        $this->$guardName = $guardName;
        Auth::shouldUse($this->$guardName);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard($this->guardName)->user());
    }

    public function logout()
    {
        Auth::guard($this->guardName)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard($this->guardName)->user(), Auth::guard($this->guardName)->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($user, $token)
    {
        return response()->json([
            'status'=>200,
            'token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
