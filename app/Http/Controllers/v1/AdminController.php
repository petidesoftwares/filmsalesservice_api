<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function store(){
        $admin = public_path('videos');
        return response()->json(['admin'=>$admin]);
    }
}
