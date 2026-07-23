<?php

use App\Models\AdoptionMatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {

    dd('channels.php reached');

    $match = AdoptionMatch::whereHas('chat', function ($query) use ($chatId) {
        $query->where('id', $chatId);
    })->first();

    if (!$match) {
        return false;
    }

    $guard = request()->header('X-Guard');

    // webユーザー
    if ($user instanceof \App\Models\User) {
        return $match->user_id === $user->id();
    }

    if ($user instanceof \App\Models\Organization) {
        return $match->animal->organization_id === $user->id();
    }
    
    return false;
});
