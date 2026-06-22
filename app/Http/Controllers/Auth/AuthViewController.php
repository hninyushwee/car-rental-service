<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class AuthViewController
{
    public function register(){
        return view('auth.register');
    }
    public function login(){
        return view('auth.login');
    }
}
