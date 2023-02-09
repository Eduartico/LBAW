<?php

namespace App\Policies;

use App\Models\Attend;
use App\Models\Event;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;

class AttendPolicy
{
    //todo
    public function create(User $user,Event $event){
        return $user->can('show',$event);
    }

    //todo
    public function show(){
        return Response::allow();
    }

    //todo
    public function update(){
        return Response::deny();
    }

    //todo
    public function delete(User $user, Attend $attend){
        if ($user == $attend->user()){
            return Response::allow();
        }
        if ($attend->event()->owner() == $user){
            return Response::allow();
        }
        return Response::deny();
    }


}
