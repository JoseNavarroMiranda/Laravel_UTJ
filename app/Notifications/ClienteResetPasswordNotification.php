<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClienteResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(private string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('cliente.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Solicitud de restablecimiento de contraseña')
            ->greeting('Hola ' . ($notifiable->nombre ?? ''))
            ->line('Recibiste este correo porque se solicitó restablecer la contraseña de tu cuenta de cliente.')
            ->action('Restablecer contraseña', $resetUrl)
            ->line('Si tú no solicitaste este cambio, no es necesario que realices ninguna acción.');
    }
}
