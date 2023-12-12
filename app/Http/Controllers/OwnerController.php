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
        $validator = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' =>  'required',
            'pseudo' => 'required',
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
    }
}
