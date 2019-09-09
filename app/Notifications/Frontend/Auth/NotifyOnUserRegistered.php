<?php

namespace App\Notifications\Frontend\Auth;

use App\Models\Auth\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class NotifyOnUserRegistered
 * @package App\Notifications\Frontend\Auth
 */
class NotifyOnUserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $team;


    /**
     * NotifyOnUserRegistered constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->team = Team::findOrFail($this->user->current_team_id);
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
            ->subject(app_name().': '.__('strings.emails.admin.subject'))
            ->line(__('strings.emails.admin.email_body_title'))
            ->line('Компания: '.$this->team->name)
            ->line('Пользователь: '.$this->user->full_name)
            ->line('E-mail: '.$this->user->email);
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
