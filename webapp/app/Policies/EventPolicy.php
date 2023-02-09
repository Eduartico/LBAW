<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\Post;
use App\Models\User;
use http\Env\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class EventPolicy
{
    public function create(User $user){
        return !$user->getAttribute('isAdmin');
    }

    public function show(User $user,Event $event){
        if ($event->getAttribute('status') == 'private'){
            if ($event->getAttribute('owner_id') == $user->id)
                return Response::allow();
            if (
                DB::table('organizer')
                ->where('user_id','=',$user->getKey())
                ->where('event_id','=',$event->getKey())
                ->count() > 0
            )return Response::allow();

            if (
                DB::table('invite')
                ->where('event_id','=',$event->getKey())
                ->where('invited','=',$user->getKey())
                ->count() > 0
            )return Response::allow();

            if (
                DB::table('attend')
                ->where('event_id','=',$event->getKey())
                ->where('user_id','=',$user->getKey())
                ->count() > 0
            )return Response::allow();
            if($user->is_admin)
                 return Response::allow();

            return Response::deny();
        }
        if ($event->getAttribute('status') == 'banned'){
            if ($user->is_admin){
                return Response::allow();
            }
            Response::deny();
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Event $event)
    {
        if ($event->owner()->is($user) or $event->organizers()->find($user)->count() > 0){
            return Response::allow();
        }
        if ($user->getAttribute('is_admin'))return Response::allow();

        return Response::deny();
        //TODO nao sei como prevenir o utilizador de mudar o status de banned para public
    }

    /**
     * only event owner can delete the event
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Event $event)
    {
        return $event->owner() == $user->getKey();
    }
}
