<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function show(){
        $notications = Notification::where('user_id','=',Auth::id())->orderBy('date','desc')->paginate(10);

        return view('pages.notifications',['notifications' => $notications]);
    }
}
