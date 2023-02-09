<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class PostPolicy
{
    use HandlesAuthorization;


    public function show(User $user){
        return !$user->getAttribute('isAdmin');
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return Response|bool
     */
    public function view(User $user, Post $post)
    {
        if ($user->cannot('show',$post->event())){
            return Response::deny();
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post)
    {
        //TODO
        if ($post->getAttribute('owner_id') == $user->getKey() || $user->getAttribute('is_admin'))
            return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        if($post->getAttribute('owner_id') == $user->getKey())
            return Response::allow();
    }
}
