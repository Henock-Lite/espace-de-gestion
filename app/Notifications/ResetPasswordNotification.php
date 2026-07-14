<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
 public function toMail($notifiable): MailMessage
{
    
    $nomUtilisateur = $notifiable->name ?? 'Utilisateur'; 

    return (new MailMessage)
        ->subject('Réinitialisation de votre mot de passe - PharmaSys')

        ->line('Bonjour ' . $nomUtilisateur . ',')
        ->line('Vous recevez ce message suite à une demande de modification de mot de passe pour votre espace PharmaSys.')
        ->action('Choisir un nouveau mot de passe', url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false)))
        ->line('Pour des raisons de sécurité, ce lien cessera de fonctionner dans 10 minutes.')
        ->line('Si vous n\'avez pas demandé ce changement, ignorez simplement cet e-mail.')
        ->line('L\'équipe PharmaSys');
}
}