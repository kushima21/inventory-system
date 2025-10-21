<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
 public function boot(): void
{
    View::composer('partials.navbar', function ($view) {
        $userId = auth()->check() ? auth()->id() : session('user_id');

        $bookings = collect();
        $unreadCount = 0;

        if ($userId) {
            $bookings = Booking::with('gym')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            $unreadCount = Booking::where('user_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        $view->with([
            'bookings' => $bookings,
            'unreadCount' => $unreadCount
        ]);
    });
}
}
