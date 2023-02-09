<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;


class AuthPageController extends Controller
{
    public function login(){
        return View::make('login',['message'=>'']);
    }

    public function register(){
        return View::make('register',['message' => '']);
    }

    public function notAuthorised(){
        return View::make('not-authorized');
    }
}
