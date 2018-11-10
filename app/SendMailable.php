<?php

namespace App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $link;
    public $url;
    public $email;
    public $template;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $token, $email, $template = null)
    {
        if (null === $template) {
            $template = "mail";
        }
        $this->link = urldecode($url).'/'.$token;
        $this->url = $url;
        $this->email = $email;
        $this->template = $template;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Swarm Trading')->view($this->template);
    }
}