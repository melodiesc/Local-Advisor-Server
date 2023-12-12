<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Owner;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Tentative de connexion avec les informations fournies
    //     if (Auth::attempt($credentials)) {
    //         $user = $request->user();
    //         // Générez le token d'authentification pour l'utilisateur
    //         $token = $user->createToken('authToken')->plainTextToken;
    //         return response()->json(['token' => $token], 200);
    //     }

    //     // En cas d'échec de l'authentification, retournez une erreur
    //     throw ValidationException::withMessages([
    //         'email' => ['Les informations d\'identification fournies sont incorrectes.'],
    //     ]);

    // }
    public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        $user = Owner::where('email', $credentials['email'])->first();
    }
    
    if ($user && Hash::check($credentials['password'], $user->password)) {
        // Utilisateur trouvé dans la table "users" ou "owners"
        // Traitez en conséquence s'il est un utilisateur ou un propriétaire
        // ...

        // Générer le token d'authentification
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    throw ValidationException::withMessages([
        'email' => ['Les informations d\'identification fournies sont incorrectes.'],
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
