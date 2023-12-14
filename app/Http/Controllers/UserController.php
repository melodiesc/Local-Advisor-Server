<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserByCSRF(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }

    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(Rate $rate)
    {
        //
    }


    public function edit(Rate $rate)
    {
        //
    }

    public function update(Request $request, Rate $rate)
    {
        //
    }

    public function destroy(Rate $rate)
    {
        //
    }
//
}
