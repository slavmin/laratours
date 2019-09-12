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
     * @var mixed
     */
    public $email;
    public $name;
    public $phone;
    public $message;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->email = $request->get('email');
        $this->name = $request->get('name');
        $this->phone = $request->get('phone');
        $this->message = $request->get('message');
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
                ->with('email', $this->email)
                ->with('name', $this->name)
                ->with('phone', $this->phone)
                ->with('message', $this->message)
            ->text('frontend.mail.contact-text')
                ->with('email', $this->email)
                ->with('name', $this->name)
                ->with('phone', $this->phone)
                ->with('message', $this->message)
            ->subject(__('strings.emails.contact.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->email, $this->name);
    }
}
