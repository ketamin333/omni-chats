<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        return response()->json($request->all());
    }

    public function logout(Request $request)
    {
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
