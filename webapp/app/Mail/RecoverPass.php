<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoverPass extends Mailable
{
    use Queueable, SerializesModels;

    public $user_receiver;
    public $new_pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_receiver, $new_pass)
    {
        $this->user_receiver = $user_receiver;
        $this->new_pass = $new_pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('helluvaEM@gmail.com')
                    ->view('emails.welcome');
    }


}
