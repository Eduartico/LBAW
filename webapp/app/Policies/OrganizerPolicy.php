<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizerPolicy
{
    public function create(User $user,$context){
        //TODO
    }

    public function update(){
        return Response::allow();
    }

    public function view(User $user,Organizer $organizer){
        $user->can('view',$organizer->event()->get());
    }

    public function delete(User $user,Organizer $organizer){

        if($organizer->event()->where('owner_id','=',$user->getKey())->exists()){
            return Response::allow();
        }
        return Response::deny();
    }
}
