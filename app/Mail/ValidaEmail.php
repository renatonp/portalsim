<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidaEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd( $this->usuario["token"] );
        return $this->subject('[SIM] Validação de Email')
                    ->markdown('emails.validaemail', [
                        'url' => url(config('app.url').route('cgm_valida_email', $this->usuario["token"], false)),
                        'nome' => $this->usuario["nome"],
                        'novoEmail' => $this->usuario["novoEmail"],
                    ]);
    }
}