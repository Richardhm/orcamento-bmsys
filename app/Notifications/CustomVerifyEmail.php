<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Gera a URL de verificação manualmente
        //route('verification.verify', ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]);
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
        return (new MailMessage)
            ->subject('Confirme seu Endereço de E-mail')
            ->greeting('Olá, seja bem-vindo!')
            ->line('Estamos felizes em tê-lo conosco. Clique no botão abaixo para verificar seu endereço de e-mail:')
            ->action('Verificar E-mail', $verificationUrl)
            ->line('Se você não criou uma conta, por favor desconsidere esta mensagem.')
            ->salutation('Atenciosamente, Equipe BmSyS');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
