<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShipped extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $order;
    public function __construct( Order $order)
    {
        $this->order=$order ; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
      $address=$this->order->billingAddress->first();
        return (new MailMessage)
            ->subject("({New Order (#{$this->order->number}")
            ->line("New Order (#{$this->order->number}) created by {$address->first_name}")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

      public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $address = $this->order->billingAddress->first();

        return new BroadcastMessage([
            'order_id'     => $this->order->id,
            'order_number' => $this->order->number,
            'customer'     => $address->first_name,
            'message'      => "New Order (#{$this->order->number}) created by {$address->first_name}",
            'url'          => url('/dashboard'),
            'created_at'   => now()->toDateTimeString(),
        ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
