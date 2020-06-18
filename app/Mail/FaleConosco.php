<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FaleConosco extends Mailable
{
    use Queueable, SerializesModels;
    protected $mensagem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[SIM] Fale Conosco')
                    ->markdown('emails.faleconosco', [
                        'mensagem' => $this->mensagem
                    ]);
    }
}