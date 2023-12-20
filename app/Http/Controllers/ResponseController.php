<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
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
    public function store(Request $request)
    {
        try{
            
        $response = new Response([
            'content' => $request->input('content'),
            'owner_id' => $request->input('owner_id'),
            'notice_id' => $request->input('notice_id'),
        ]);

        $response->save();

        return response()->json(['message' => 'Réponse postée avec succès']);

        } catch(\Exception $e) {
            Log::error('Error in ResponseController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Error storing response'], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Response $response)
    {
        //
    }
}
