<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends AppAuthController
{
    public const GUARD = 'admins';
    /**
     * Create a new AminAuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(AdminAuthController::GUARD);

    }

    /**
     * Admin login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request){
        if(Auth::guard('admins')->attempt($request->only(['email','password']))){
            return 'yea';
        }
        return 'nay';
    }
}
