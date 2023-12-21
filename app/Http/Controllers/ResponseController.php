<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Création d'une nouvelle instance de Response avec les données fournies dans la requête
            $response = new Response([
                'content' => $request->input('content'),
                'owner_id' => $request->input('owner_id'),
                'notice_id' => $request->input('notice_id'),
            ]);

            // Sauvegarde de la nouvelle réponse dans la base de données
            $response->save();

            // Retour d'une réponse JSON indiquant que la réponse a été postée avec succès
            return response()->json(['message' => 'Réponse postée avec succès']);

        } catch(\Exception $e) {
            // En cas d'erreur, journalisation de l'erreur et retour d'une réponse JSON avec un message d'erreur et le code HTTP 500 (Internal Server Error)
            Log::error('Error in ResponseController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Error storing response'], 500);
        }
    }

    public function show($id)
    {
        try {
            // Requête pour récupérer les réponses liées à une location spécifique
            $responses = DB::table('responses')
                ->join('notices', 'responses.notice_id', '=', 'notices.id')
                ->join('locations', 'notices.location_id', '=', 'locations.id')
                ->join('owners', 'responses.owner_id', '=', 'owners.id')
                ->select('responses.*', 'owners.pseudo')
                ->where('locations.id', $id)
                ->get();
    
            // Retour d'une réponse JSON contenant les réponses
            return response()->json($responses);
        } catch (\Exception $e) {
            // En cas d'erreur, journalisation de l'erreur et retour d'une réponse JSON avec un message d'erreur et le code HTTP 500 (Internal Server Error)
            Log::error('Error in ResponseController@show: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching responses'], 500);
        }
    }    


    public function edit(Response $response)
    {
        //
    }


    public function update(Request $request, Response $response)
    {
        //
    }


    public function destroy(Response $response)
    {
        //
    }
}
