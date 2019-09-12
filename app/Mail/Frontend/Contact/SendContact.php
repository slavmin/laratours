<?php

namespace App\Mail\Frontend\Contact;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendContact extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('contacts.contact.address'), config('contacts.contact.name'))
            ->view('frontend.mail.contact')
            ->text('frontend.mail.contact-text')
            ->subject(__('strings.emails.contact.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->request['email'], $this->request['name']);
    }
}
