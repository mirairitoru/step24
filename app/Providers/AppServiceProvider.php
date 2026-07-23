<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            if(Auth::guard('org')->check()) {
                $organizationId = Auth::guard('org')->id();

                $myChatIds = \App\Models\Chat::whereHas('match.animal', function($q) use ($organizationId) {
                    $q->where('organization_id', $organizationId);
                })->pluck('id');

                $totalUnread = \App\Models\Message::whereIn('chat_id', $myChatIds)
                    ->where('sender_type', 'user')
                    ->whereDoesntHave('reads', function($q) use ($organizationId) {
                        $q->where('reader_type', 'organization')
                        ->where('reader_id', $organizationId);
                    })
                    ->count();
                return $view->with('totalUnread', $totalUnread);
            }

            if(Auth::guard('web')->check()) {
                $userId = Auth::guard('web')->id();

                $myChatIds = \App\Models\Chat::whereHas('match', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->pluck('id');

                $totalUnread = \App\Models\Message::whereIn('chat_id', $myChatIds)
                    ->where('sender_type', 'organization')
                    ->whereDoesntHave('reads', function($q) use ($userId) {
                        $q->where('reader_type', 'user')
                        ->where('reader_id', $userId);
                    })
                    ->count();
                return $view->with('totalUnread', $totalUnread);
            }
        });
    }
}
