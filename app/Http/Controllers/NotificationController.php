<?php

namespace App\Http\Controllers;

use App\Events\YourNotificationEvent;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $message = $request->input('message');
        $notification = Notification::create(['message' => $message]);
        event(new YourNotificationEvent($notification));
        return response()->json(['message' => 'Notification created successfully'], 201);
    }

}
