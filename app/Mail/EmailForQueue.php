<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailForQueue extends Mailable
{
    use Queueable, SerializesModels;

    protected $title, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $password)
    {
        $this->title = $title;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.send-email')
            ->subject($this->title)
            ->from(env('MAIL_FROM_ADDRESS'), 'Serempre')
            ->with([
                'title' => $this->title,
                'password' => $this->password
            ]);

        // return $this->markdown('email.send-email');
    }
}
