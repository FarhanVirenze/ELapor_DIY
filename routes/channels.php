<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Private channel untuk user - hanya user yang sama bisa subscribe
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id_user === (int) $id;
});
