<?php

namespace App\Policies;


use App\Models\Event;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitePolicy
{
    public function create(User $user,Event $event){
        return $user->can('show',$event);
    }

    public function show(User $user,Invite $invite){
        if ($invite->inviter()->is($user) || $invite->invited()->is($user)){
            return Response::allow();
        }
        return Response::deny();
    }

    public function update(){
        Response::deny();
    }


    public function delete(User $user,Invite $invite){
        if ($invite->inviter()->is($user)){
            return Response::allow();
        }
        return Response::deny();
    }

}
