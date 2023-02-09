<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\View;

class StaticPagesController{
    
    public function faq(){
        return view('pages.static.faq');
    }

    public function aboutus(){
        return view('pages.static.aboutus');
    }

    public function contactus(){
        return view('pages.static.contactus');
    }
}
