<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class OwnerController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validation des données d'entrée
            $validator = Validator::make($request->all(), [
                'lastname' => 'required',
                'firstname' => 'required',
                'pseudo' => 'required|unique:owners',
                'birth_date' => 'required',
                'email' => 'required|email|unique:owners',
                'password' => 'required',
            ]);
    
            // Vérification s'il y a des erreurs de validation
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'data' => $validator->errors(),
                ]);
            } else {
                // Création d'un nouvel utilisateur de type "Owner"
                $owner = Owner::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'pseudo' => $request->pseudo,
                    'birth_date' => $request->birth_date,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
    
                // Retour d'une réponse JSON indiquant que l'utilisateur a été enregistré avec succès
                return response()->json([
                    'status' => 'true',
                    'message' => 'Utilisateur bien enregistré!',
                ]);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retour d'une réponse JSON avec un message d'erreur et le code HTTP 500 (Internal Server Error)
            return response()->json([
                'status' => 'false',
                'message' => 'Une erreur s\'est produite lors de l\'enregistrement.',
                'error' => $e->getMessage(),
            ], 500);
        }   
    }

}
