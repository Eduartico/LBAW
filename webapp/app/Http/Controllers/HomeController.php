<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Event;

class HomeController extends Controller
{


    const ITEMS_PER_PAGE = 10;

    public function show(){
        $events = Event::where([
            ['status', 'public']
        ])->get();

        return view('pages.home', ['events' => $events]);
    }

}
