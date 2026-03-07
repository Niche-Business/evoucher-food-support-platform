<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function getUnread()
    {
        $count = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function delete(Notification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true]);
    }
}
