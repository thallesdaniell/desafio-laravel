<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function permission(User $userAuth, User $user)
    {
        $owner = $user->from_guest;
        $type  = is_null($owner) ? $user->id : $owner->user_id;

        return $userAuth->id === $user->id
            || $userAuth->id === $type;
    }
}
