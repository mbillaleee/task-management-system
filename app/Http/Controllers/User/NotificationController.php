<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /** Full notifications page */
    public function index(Request $request)
    {
        $user   = auth()->user();
        $filter = $request->query('filter', 'all');

        $query = $user->notifications();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter !== 'all') {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) LIKE ?", ["%{$filter}%"]);
        }

        $notifications = $query->latest()->paginate(20);
        $unreadCount   = $user->unreadNotifications()->count();

        // Group stats
        $stats = [
            'all'    => $user->notifications()->count(),
            'unread' => $unreadCount,
            'task'   => $user->notifications()->whereRaw("JSON_EXTRACT(data, '$.type') LIKE '%task%'")->count(),
            'habit'  => $user->notifications()->whereRaw("JSON_EXTRACT(data, '$.type') LIKE '%habit%'")->count(),
            'goal'   => $user->notifications()->whereRaw("JSON_EXTRACT(data, '$.type') LIKE '%goal%'")->count(),
            'focus'  => $user->notifications()->whereRaw("JSON_EXTRACT(data, '$.type') LIKE '%focus%'")->count(),
        ];

        return view('user.notifications.index', compact('notifications', 'unreadCount', 'filter', 'stats'));
    }

    /** Mark single notification as read */
    public function markRead(string $id)
    {
        $notif = auth()->user()->notifications()->findOrFail($id);
        $notif->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        // Redirect to the notification's URL if available
        $url = $notif->data['url'] ?? route('user.notifications.index');
        return redirect()->route('user.notifications.index')->with('success', 'Notification marked as read.')->with('redirect_url', $url);
    }

    /** Mark all as read */
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'count' => 0]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /** Delete single */
    public function destroy(string $id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification removed.');
    }

    /** Delete all read notifications */
    public function clearRead()
    {
        auth()->user()->readNotifications()->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Cleared all read notifications.');
    }

    /** API endpoint for navbar bell — returns unread count + recent 5 */
    public function bell()
    {
        $user  = auth()->user();
        $items = $user->unreadNotifications()
            ->latest()
            ->take(8)
            ->get()
            ->map(fn($n) => [
                'id'      => $n->id,
                'title'   => $n->data['title']   ?? 'Notification',
                'message' => $n->data['message']  ?? '',
                'icon'    => $n->data['icon']     ?? '🔔',
                'type'    => $n->data['type']     ?? 'general',
                'url'     => $n->data['url']      ?? '#',
                'time'    => $n->created_at->diffForHumans(),
                'read'    => !is_null($n->read_at),
            ]);

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'items' => $items,
        ]);
    }
}
