<?php

namespace App\Broadcasting;

use App\Models\Product;
use App\Models\User;
use Illuminate\Notifications\Notification;

class Notifications extends Notification
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    protected $product;
    protected $message;

    public function __construct(Product $product, $message = null)
    {
        $this->product = $product;
        $this->message = $message ?? 'تم تحديث المنتج بنجاح!';
    }

    public function via($notifiable)
    {
        return ['broadcast'];  // للإرسال إلى قاعدة البيانات فقط
    }

    public function broadcastOn()
    {
        return ['notifications'];
    }

    public function broadcastAs()
    {
        return 'product.notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'product_id' => $this->product->id,
        ];
    }
    public function toArray($notifiable)
{
    return [
        'message' => $this->message,
        'product_id' => $this->product->id,
    ];
}

}