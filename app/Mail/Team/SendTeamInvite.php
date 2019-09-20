<?php

namespace App\Mail\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTeamInvite extends Mailable
{
    use Queueable, SerializesModels;

    protected $invite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->invite->email)
            ->markdown('frontend.mail.team-invite')
            ->subject(app_name() . ': ' . __('strings.emails.teams.subject') . ' ' . $this->invite->team->name)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->with([
                'text' => __('strings.emails.teams.subject') . ' ' . $this->invite->team->name,
                'accept_url' => route('frontend.auth.invited.register', $this->invite->accept_token),
                'accept_text' => __('buttons.emails.teams.accept_invite'),
                'link_text' => __('strings.emails.teams.button_to_link_text') . route('frontend.auth.invited.register', $this->invite->accept_token),
            ]);
    }
}
