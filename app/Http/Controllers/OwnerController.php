<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class OwnerController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'lastname' => 'required',
                'firstname' =>  'required',
                'pseudo' => 'required|unique:owners',
                'birth_date' => 'required',
                'email' => 'required|email|unique:owners',
                'password' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'false',
                    'data' => $validator->errors()
                ]);
            } else {
                $user = Owner::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'pseudo' => $request->pseudo,
                    'birth_date' => $request->birth_date,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $token = $user->createToken('owner_token')->plainTextToken;
                
                return response()->json([
                    'status' => 'true',
                    'message'=> 'Utilisateur bien enregistré!',
                    'data' => $token,
                ]);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retournez une réponse appropriée
            return response()->json([
                'status' => 'false',
                'message' => 'Une erreur s\'est produite lors de l\'enregistrement.',
                'error' => $e->getMessage(), // Pour obtenir des détails sur l'erreur
            ], 500); // Vous pouvez également utiliser un code d'erreur différent si nécessaire
        }   
    }
}
