<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClientPolicy
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

    public function permission(User $user, Client $client)
    {
        $owner = $user->from_guest;
        $type  = is_null($owner) ? $user->id : $owner->user_id;

        $check = Guest::where('user_id', $type)
            ->whereHas('user', function (Builder $query) use ($client) {
                $query->whereHas('client', function (Builder $query) use ($client) {
                    $query->where('id', $client->id);
                });
            })->get()->isNotEmpty();


        return $user->id === $client->user_id || $check;

    }
}
