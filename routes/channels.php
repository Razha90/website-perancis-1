<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
//     return (int) $user->id === (int) $receiverId;
// });

Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    Log::info('terhubung', ['user' => $user]);
    return (int) $user->id === (int) $receiverId || (int) $user->id === (int) request()->sender_id;
});
