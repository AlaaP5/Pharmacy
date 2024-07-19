<?php

namespace App\Listeners;

use App\Broadcasting\Notifications;
use App\Events\NewNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationListener
{
    /*
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
     * Handle the event.
     *
     * @param  \App\Events\NewNotification  $event
     * @return void
     */
    public function handle(NewNotification $event)
    {
        $users = User::all();  // استرجع جميع المستخدمين
    
        $notificationMessage = $event->message;  // استخدم الرسالة المُرسلة في الحدث
    
        // تحديد نوع الرسالة وتعيين الرسالة المناسبة
        if ($event->type === 'expiry') {
            $notificationMessage = 'The product expiration date has passed!';
        } elseif ($event->type === 'out_of_stock') {
            $notificationMessage = 'The product is out of stock!';
        }
    
        foreach ($users as $user) {
            $user->notify(new Notifications
            ($event->product, $notificationMessage)); 
    }
}
    
}