<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class RegisterController extends Controller
{
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'lastname' => 'required',
                'firstname' =>  'required',
                'pseudo' => 'required|unique:users',
                'birth_date' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
        
            if($validator->fails()){
                return response()->json([
                    'status' => 'false',
                    'data' => $validator->errors()
                ]);
            } else {
                $user = User::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'pseudo' => $request->pseudo,
                    'birth_date' => $request->birth_date,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
        
                $token = $user->createToken('user_token')->plainTextToken;
                
                return response()->json([
                    'status' => 'true',
                    'message'=> 'Utilisateur bien enregistré!',
                    'data' => $token,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'Une erreur s\'est produite lors de l\'enregistrement.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
