<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user,Post $post){

        if ($user->getAttribute('isAdmin')){
            return Response::deny();
        }

        $event = $post->event();

        if ($event->get('status') == 'private'){
            if ($event->get('owner_id'))return Response::allow();
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
            if($user->is_admin)return Response::allow();
            return Response::deny();
        }

        return Response::allow();

    }

    public function show(User $user, Comment $comment){
        $parent_post = DB::table('post')->where('id','=',$comment->getAttribute('parent_post'))->first();
        $parent_event = DB::table('event')->where('id','=',$parent_post->getAttribute('eveent_id'))->first();

        if ($parent_post->getAttribute('status') == 'private'){
            if (
                DB::table('organizer')
                    ->where('user_id','=',optional($user)->getKey())
                    ->where('event_id','=',$parent_event->getKey())
                    ->count() > 0
            )return Response::allow();

            if (
                DB::table('invite')
                    ->where('event_id','=',$parent_event->getKey())
                    ->where('invited','=',$user->getKey())
                    ->count() > 0
            )return Response::allow();

            if (
                DB::table('attend')
                    ->where('event_id','=',$parent_event->getKey())
                    ->where('user_id','=',$user->getKey())
                    ->count() > 0
            )return Response::allow();

            return Response::deny('');
        }
        return Response::allow();
    }

    public function update(User $user,Comment $comment){
        if ($comment->getAttribute('owner_id') == $user->getKey())
            return Response::allow();
    }

    public function delete(User $user,Comment $comment){
        if ($comment->getAttribute('owner_id') == $user->getKey())
            return Response::allow();
    }
}
