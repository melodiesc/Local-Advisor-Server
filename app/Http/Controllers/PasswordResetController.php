<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User; // Remplacez par votre modèle d'utilisateur si nécessaire
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function sendResetEmail(Request $request)
    {
        // Récupérez l'utilisateur pour lequel vous souhaitez envoyer l'e-mail de réinitialisation
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            // Créez une instance de la classe ResetPasswordEmail et passez l'utilisateur en paramètre
            $resetEmail = new ResetPasswordEmail($user);

            // Envoyez l'e-mail en utilisant la méthode send() de la classe Mail de Laravel
            Mail::to($user->email)->send($resetEmail);

            // Gérez la réponse après l'envoi de l'e-mail, par exemple, redirigez l'utilisateur vers une page appropriée
            return redirect()->back()->with('success', 'E-mail de réinitialisation envoyé avec succès.');
        }

        // Gérez le cas où l'utilisateur n'est pas trouvé ou l'e-mail n'est pas valide
        return redirect()->back()->with('error', 'Aucun utilisateur trouvé avec cette adresse e-mail.');
    }
}
