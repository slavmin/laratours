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
    protected $data;

    /**
     * SendContact constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('contacts.contact.address'), config('contacts.contact.name'))
            ->markdown('frontend.mail.contact')
            ->subject(__('strings.emails.contact.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->data['email'], $this->data['name'])
            ->with([
                'email' => $this->data['email'],
                'name' => $this->data['name'],
                'phone' => $this->data['phone'],
                'body' => $this->data['message'],
            ]);
    }
}
