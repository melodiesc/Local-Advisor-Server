<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
// Définit le sujet de l'e-mail et la vue à utiliser pour le contenu de l'e-mail
    public function build()
    {
        return $this->subject('Réinitialisation de mot de passe')
            ->view('emails.reset_password')
            ->with([
                'resetLink' => $this->generateResetLink($this->user), // Génération du lien de réinitialisation
            ]);
    }

    public function generateResetLink($user)
    {
        // Générer un lien pour réinitialiser le mot de passe pour cet utilisateur
        return URL::signedRoute('password.reset', ['user' => $user->id]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('jeffrey@example.com', 'Jeffrey Way'),
            subject: 'Order Shipped',
        );
    }

    public function content()
    {
        return new Content(
            view: 'resetPasswordEmail',
        );
    }

    public function attachments()
    {
        // Si vous avez des pièces jointes à ajouter, faites-le ici
        return [
            // Exemple d'ajout d'une pièce jointe
            // $this->attach(storage_path('file.txt'))
        ];
    }
}
