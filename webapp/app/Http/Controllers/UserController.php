<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function AttendingEvents()
    {
        $user = Auth::user();
        $events = $user->attends()->simplepaginate(10);

        return view('pages.paginated-event-list', ['events' => $events, 'title' => 'Attending Events']);
    }

    public function OrganizingEvents()
    {
        $user = Auth::user();
        $events = $user->organizes()->simplepaginate(10);

        return view('pages.paginated-event-list', ['events' => $events, 'title' => 'Managing Events']);
    }
    public function OwningEvents(){
        $user = Auth::user();
        $events = $user->events()->simplepaginate(10);

        return view('pages.paginated-event-list', ['events' => $events, 'title' => 'Own Events']);
    }

    public function Invites(){
        $invites = Auth::user()->Invited()->simplepaginate(10);

        return view('pages.invites',['invites' => $invites]);

    }

    public function show(){
		$user = Auth::user();

		if ($user != null)
			return view('pages.users.profile', ['user' => $user]);
		else
			return redirect()->back();
    }

    public function edit()
    {
        $user = Auth::user();

		if (auth()->user()->can('update', $user))
			return view('pages.users.edit-profile', ['user'=>$user]);
		else
			return redirect()->back();
    }

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' =>'nullable|file|mimes:png,jpeg,gif',
            'name' => 'required|string',
            'password' => 'required_if:new_password,password-confirmation|string|max:40',
            'new-password' => 'required_if:password,password-confirmation|string|min:8|max:40',
            'password-confirmation' => 'required_if:password,new-password|string'
        ]);
        if ($validator->fails()){
            redirect()->back()->withErrors($validator->errors());
        }

		try{
            $user = Auth::user();

            $user->name = $request->input('name');
            if (Hash::check($request->input('password'),Auth::user()->password)){
                if ($request->input('new-password') ==  $request->input('password-confirmation')) {
                    $user->password = Hash::make($request->input('new-password'));
                }else{
                    return redirect()->back()->withErrors(['password'=>'new password confirmation different from new password']);
                }
            }else{
                return redirect()->back()->withErrors(['password'=>'wrong password']);
            }

            $user->save();

            DB::commit();

            Log::info('User ' . $user->name . ' with id:' . $user->id . ' updated profile');
            return redirect('/user')->with('success', 'Your profile was updated!');
        }
        catch(QueryException $e){
            DB::rollBack();
            return redirect('/')->with('error', 'Error in submiting request to database');
        }
    }

}
