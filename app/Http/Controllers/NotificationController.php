<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display the user's notifications.
     */
    public function index(Request $request): View
    {
        $notifications = $request
            ->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $user = $request->user();

        $user
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail()
            ->markAsRead();

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request
            ->user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}
