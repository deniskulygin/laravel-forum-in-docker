<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * @param User $user
     * @param string $notificationId
     */
    public function destroy(User $user, string $notificationId)
    {
        $user->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
