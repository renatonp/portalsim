<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $verificationUrl;
    protected $notifiable;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verificationUrl, $notifiable)
    {
        $this->verificationUrl = $verificationUrl;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.verifyemail',[
            'url' => $this->verificationUrl,
            'name' => $this->notifiable->name,
        ]);
    }
}
