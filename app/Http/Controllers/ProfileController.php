<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request, $userType)
    {
        $user = $request->user();

        if ($userType === 'owner') {
            $profileData = Owner::find($user->id);
        } elseif ($userType === 'user') {
            $profileData = User::find($user->id);
        } else {
            return response()->json(['error' => 'Invalid userType'], 400);
        }

        // Vérifiez si le profil existe
        if (!$profileData) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        return response()->json($profileData);
    }

    public function update(Request $request, $userType)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|unique:' . ($userType === 'owner' ? 'owners' : 'users') . ',email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $profileModel = ($userType === 'owner') ? Owner::class : User::class;
        $profileData = $profileModel::find($user->id);

        if (!$profileData) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $profileData->fill($request->only(['firstname', 'lastname', 'birth_date', 'pseudo', 'email']));

        $profileData->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
