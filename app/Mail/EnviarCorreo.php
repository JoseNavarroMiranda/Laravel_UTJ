<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo extends Mailable {
    use Queueable, SerializesModels;
    public $mensaje;

    public function __construct($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function envelope(): Envelope {
        return new Envelope(subject: 'Correo de Prueba Laravel 12');
    }

    public function content(): Content {
        return new Content(view: 'email.email', with: ['mensaje' => $this->mensaje]);
    }

    public function attachments(): array {
        return [];
    }
}
