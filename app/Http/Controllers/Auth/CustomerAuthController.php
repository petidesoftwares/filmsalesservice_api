<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends AppAuthController
{
    public const GUARD = 'customers';
    /**
     * Create a new CustomerController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(CustomerAuthController::GUARD);

    }

    /**
     * Customer login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credential =[
            'email'=>$request->input('email'),
            'password'=>$request->input('password')
        ];
        if($token = Auth::attempt($credential)){
            $user = Auth::user();
            return $this->respondWithToken($user, $token);
        }
        return response()->json(['error'=>'Your are not an authorized customer. Contact developers for proper directions'],403);

    }
}
