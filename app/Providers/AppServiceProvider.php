<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        //
        Inertia::share([
            'flash' => function () {
                return [
                    'success' => session('success'),
                    'error' => session('error'),
                ];
            },
            'auth.notifications' => function () {
                if (auth()->check()) {
                    return auth()->user()->notifications()
                        ->with('notificationType')
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function ($notification) {
                            return [
                                'id' => $notification->id,
                                'type' => $notification->notificationType->type,
                                'content' => $notification->content,
                                'sender_id' => $notification->sender_id,
                                'status' => $notification->status,
                                'read_at' => $notification->read_at,
                                'created_at' => $notification->created_at->diffForHumans(),
                            ];
                        });
                }

                return [];
            }
        ]);
    }
}
