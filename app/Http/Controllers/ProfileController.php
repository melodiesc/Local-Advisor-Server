<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request, $userType)
    {
        // Récupération de l'utilisateur à partir de la requête
        $user = $request->user();

        // Vérification du type d'utilisateur spécifié dans l'URL
        if ($userType === 'owner') {
            // Récupération des données de profil à partir de la table 'owners' pour le type 'owner'
            $profileData = Owner::find($user->id);
        } elseif ($userType === 'user') {
            // Récupération des données de profil à partir de la table 'users' pour le type 'user'
            $profileData = User::find($user->id);
        } else {
            // Retour d'une réponse JSON avec une erreur si le type d'utilisateur est invalide
            return response()->json(['error' => 'Invalid userType'], 400);
        }

        // Vérification si le profil existe
        if (!$profileData) {
            // Retour d'une réponse JSON avec une erreur si le profil n'est pas trouvé
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Retour d'une réponse JSON contenant les données du profil
        return response()->json($profileData);
    }


    public function update(Request $request, $userType)
    {
        // Récupération de l'utilisateur à partir de la requête
        $user = $request->user();

        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|unique:' . ($userType === 'owner' ? 'owners' : 'users') . ',email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Vérification s'il y a des erreurs de validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Détermination du modèle de profil en fonction du type d'utilisateur
        $profileModel = ($userType === 'owner') ? Owner::class : User::class;

        // Récupération des données de profil à partir de la table appropriée
        $profileData = $profileModel::find($user->id);

        // Vérification si le profil existe
        if (!$profileData) {
            // Retour d'une réponse JSON avec une erreur si le profil n'est pas trouvé
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Mise à jour des données de profil avec les données fournies dans la requête
        $profileData->fill($request->only(['firstname', 'lastname', 'birth_date', 'pseudo', 'email']));

        // Mise à jour du mot de passe s'il est fourni
        if ($request->filled('password')) {
            $profileData->password = Hash::make($request->password);
        }

        // Sauvegarde des modifications dans la base de données
        $profileData->save();

        // Retour d'une réponse JSON indiquant que le profil a été mis à jour avec succès
        return response()->json(['message' => 'Profile updated successfully']);
    }

}
