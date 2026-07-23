<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return back();
    }

    public function show(DatabaseNotification $notification)
    {
        $organization = Auth::guard('org')->user();

        abort_unless(
            $notification->notifiable_id === $organization->id,
            403
        );
        
        $notification->markAsRead();
        return redirect($notification->data['url']);
    }
}
