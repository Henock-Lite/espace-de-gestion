<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    // 1. Afficher le formulaire de demande de lien
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }


    // 2. Envoyer le lien de réinitialisation
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // 1. On récupère l'utilisateur via le fournisseur de mot de passe de Laravel
        $user = Password::getUser($request->only('email'));

        if ($user) {
            // 2. S'il existe, on détruit son token actuel dans la base de données
            Password::getRepository()->delete($user);
        }

        // 3. On génère et envoie le nouveau lien (Laravel va créer un jeton tout neuf)
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::ResetLinkSent
            ? back()->with('success', 'Lien de réinitialisation envoyé.')
            : back()->withErrors(['email' => __($status)]);
    }

    // 3. Afficher le formulaire de saisie du nouveau mot de passe
    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // 4. Enregistrer le nouveau mot de passe en base de données
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Ici, la validation native fonctionnera parfaitement
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->update(['password' => Hash::make($password)]);
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé.')
            : back()->withErrors(['email' => __($status)]);
    }
}