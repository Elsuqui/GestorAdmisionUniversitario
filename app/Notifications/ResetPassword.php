<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Cambiar contraseña')
            ->line('Este mensaje ha sido enviado a partir de una petición para el cambio de contraseña')
            ->line('Dar click en el botón para cambiar la contraseña')
            ->action('Cambiar contraseña', url(config('app.url') . route('password.reset', ['token' => $this->token], false)))
            ->line('Este link de petición expirará en ' . config('auth.passwords.users.expire') . ' minutos')
            ->line('Si usted no realizó esta petición, omitir el presente correo y comunicarse con el administrador');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
