<?php

namespace App\Notifications\Frontend\Order;

use App\Models\Tour\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReplyOnOrderCreated extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $order;

    /**
     * @var
     */
    protected $tour;


    /**
     * NotifyOnOrderCreated constructor.
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->tour = Tour::whereId($this->order->tour_id)->AllTeams()->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('strings.emails.order.subject') . ' ' . app_name())
            ->greeting(__('strings.emails.auth.greeting'))
            ->line(__('strings.emails.order.reply.created', ['tour_name' => $this->tour->name]))
            ->line(__('strings.emails.order.reply.wait'))
            ->line(__('strings.emails.auth.thank_you_for_using_app'))
            ->line(__('strings.emails.auth.regards'))
            ->line(app_name());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
