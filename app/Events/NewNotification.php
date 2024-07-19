<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $product;
    public $message;
    public $type;

    public function __construct(Product $product, $message = null,$type)
    {
        $this->product = $product;
        $this->message = $message ?? 'تم تحديث المنتج بنجاح!';
        $this->type = $type;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
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
}