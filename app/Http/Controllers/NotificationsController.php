<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationsModel;

class NotificationsController extends Controller
{
    //

    public function get_all_notifications(Request $request) {
        $notifications = NotificationsModel::select('id','message', 'post_id', 'has_opened', 'notification_type')
            ->where('to_user_id', auth()->user()->id)
            ->limit(50)
            ->orderBy('id', 'desc')
            ->get();
        return view('notifications', ['notifications' => $notifications]);
    }

    public function read_notification(Request $request) {
        $get_notification = NotificationsModel::find($request->notification_id);
        $get_notification->has_opened = true;
        $get_notification->save();
        return json_encode(1);
    }

    public function unread_notification(Request $request) {
        $get_notification = NotificationsModel::find($request->notification_id);
        $get_notification->has_opened = false;
        $get_notification->save();
        return json_encode(1);
    }
}
