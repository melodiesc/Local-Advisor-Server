<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Owner;

class LoginController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validation des informations d'identification fournies (email et mot de passe)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Recherche d'un utilisateur avec l'email fourni dans la table 'users'
        $user = User::where('email', $credentials['email'])->first();
        $isOwner = false;
    
        // Si aucun utilisateur n'est trouvé dans la table 'users', recherche dans la table 'owners'
        if (!$user) {
            $user = Owner::where('email', $credentials['email'])->first();
            $isOwner = true;
        }
    
        // Vérification si l'utilisateur existe et si le mot de passe correspond
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Génération d'un jeton d'authentification pour l'utilisateur
            $token = $user->createToken('authToken')->plainTextToken;
    
            // Retour d'une réponse JSON avec le jeton, les détails de l'utilisateur et une indication s'il est propriétaire
            return response()->json([
                'token' => $token,
                'user' => $user,
                'isOwner' => $isOwner,
            ], 200);
        }
    
        // En cas d'échec de l'authentification, retour d'une exception avec un message d'erreur
        throw ValidationException::withMessages([
            'email' => ['Les informations d\'identification fournies sont incorrectes.'],
        ]);
    }
    
    
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
