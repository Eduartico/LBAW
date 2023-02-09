<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */


    public function view(User $user, User $model){
        return ($user->id > 0);
    }


    public function update(User $user, User $model){
        return ($user->id == $model->id || $user->is_admin);
    }


    public function events(User $user, User $model){
        return ($user->id == $model->id || $user->is_admin);
    }

}
