<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailMasivoInformacion extends Mailable
{
    use Queueable, SerializesModels;
    private $interes;
    private $cid_imagen;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        //
        $this->interes = $payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->cid_imagen = \Swift_DependencyContainer::getInstance()
        ->lookup('mime.idgenerator')
        ->generateId();

        $this->withSwiftMessage(function (\Swift_Message $swift) {
            $image = new \Swift_Image(asset("imagenes/ucsg_logo.png"), "logo.png", 'image/png');
            $swift->embed($image->setId($this->cid_imagen));
        });


        $this->interes["logo"] = $this->cid_imagen;
        return $this->markdown('emails.informativos.masivo')
            ->with("data", $this->interes)
            ->subject($this->interes["asunto"]);
    }
}
