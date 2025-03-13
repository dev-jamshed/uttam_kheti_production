<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

      public function toMail($notifiable)
    {
        $array['subject'] = localize('Your order has been placed') . ' - ' . $this->order->orderGroup->order_code;
        $array['order'] = $this->order;
        $font_family = env('INVOICE_FONT');

        $mailMessage = (new MailMessage)
            ->view('backend.pages.orders.invoice', ['order' => $this->order, 'font_family' => $font_family])
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject(localize('Order Placed') . ' - ' . env('APP_NAME'));

        // Add admin emails to CC
        $adminEmails = \App\Models\User::where('user_type', 'admin')->pluck('email')->toArray();
        if (!empty($adminEmails)) {
            $mailMessage->cc($adminEmails);
        }

        return $mailMessage;
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
