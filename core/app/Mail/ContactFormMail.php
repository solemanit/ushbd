<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->data['subject'])
            ->view('emails.contact')
            ->with([
                'firstName' => $this->data['firstName'],
                'lastName'  => $this->data['lastName'],
                'email'     => $this->data['email'],
                'phone'     => $this->data['phone'] ?? null,
                'subject'   => $this->data['subject'],
                'body'      => $this->data['body'],
            ]);
    }
}
