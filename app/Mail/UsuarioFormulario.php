<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsuarioFormulario extends Mailable
{
    use Queueable, SerializesModels;

    public $formulario;

    /**
     * Create a new message instance.
     * @param $formulario
     */
    public function __construct($formulario)
    {
        $this->formulario=$formulario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Formulario levantamiento de requerimientos - SEGTICS Soluciones SAS')->markdown('email.usuario-formulario');
    }
}
