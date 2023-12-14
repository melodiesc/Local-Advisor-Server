<?php

namespace App\Http\Controllers;

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

        return response()->json($profileData);
    }
}
