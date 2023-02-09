<?php

namespace App\Http\Controllers;

// Added to support email sending.
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\RecoverPass;


class Recovery extends Controller
{
    public function sendEmail(){
        return view('auth.verify');
    }


    public function recover (Request $request){



        $user = DB::table('user')->where('email', '=', $request->email)->first();

        if($user != null){
          $id = $user->id;
          $new_pass = $this->generateRandomString(13);
          $hash_pass =  Hash::make($new_pass);
          DB::table('user')->where('id', $id)->update(['password' => $hash_pass]);
          Mail::to($user)->send(new RecoverPass($user, $new_pass));

          Log::info('User ' . $user->name . ' with id:' . $user->id . ' asked for a new password - mail sent');
          return redirect('/login')->with('success', 'Your new password has been sent to your e-mail!');
        }else{
          Log::info('E-mail ' . $request->email . ' tried to recover password - no record');
          return redirect('/send-email')->withErrors('This e-mail isnt in our records!');
        }
      }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
