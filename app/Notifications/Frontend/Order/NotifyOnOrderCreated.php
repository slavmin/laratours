<?php

namespace App\Notifications\Frontend\Order;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyOnOrderCreated extends Notification
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
     * @var
     */
    protected $customers;

    /**
     * @var
     */
    protected $team;


    /**
     * NotifyOnOrderCreated constructor.
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->tour = Tour::whereId($this->order->tour_id)->AllTeams()->first();
        $this->customers = $this->order->profiles()->where('type', 'customer')->get()->pluck('content')->first();
        $this->team = Team::findOrFail($this->order->team_id);
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
        if($this->order->by_agent){
            return (new MailMessage)
                ->subject(__('strings.emails.order.subject') . ' ' . app_name())
                ->greeting(__('strings.emails.auth.greeting'))
                ->line(__('strings.emails.order.created', ['tour_name' => $this->tour->name, 'tour_id' => $this->tour->id]))
                ->line(__('strings.emails.order.agent', ['name' => $this->team->name]))
                ->action(__('labels.frontend.auth.login_button'), route('frontend.auth.login'))
                ->line(__('strings.emails.auth.thank_you_for_using_app'))
                ->line(__('strings.emails.auth.regards'))
                ->line(app_name());

        } else {
            return (new MailMessage)
                ->subject(__('strings.emails.order.subject') . ' ' . app_name())
                ->greeting(__('strings.emails.auth.greeting'))
                ->line(__('strings.emails.order.created', ['tour_name' => $this->tour->name, 'tour_id' => $this->tour->id]))
                ->line(__('strings.emails.order.contacts'))
                ->line(__('strings.emails.order.customer', ['name' => $this->customers[0]['first_name'], 'phone' => $this->customers[0]['phone'], 'email' => $this->customers[0]['email']]))
                ->action(__('labels.frontend.auth.login_button'), route('frontend.auth.login'))
                ->line(__('strings.emails.auth.thank_you_for_using_app'))
                ->line(__('strings.emails.auth.regards'))
                ->line(app_name());
        }
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
