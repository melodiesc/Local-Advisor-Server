<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
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
        try {
            $location = Location::join('owners', 'locations.owner_id', '=', 'owners.id')
                            ->select('locations.id as location_id', 'owners.id as user_id')
                            ->first();

            $notice = new Notice([
                'location_id' => $request->input('numericId'),
                'user_id' => $request->input('user_id'),
                'comment' => $request->input('comment'),
                'rate' => $request->input('rate'),
            ]);

            $notice->save();

            return response()->json(['message' => 'Commentaire posté avec succès']);
        } catch (\Exception $e) {
            Log::info('Location ID from request: ' . $location->location_id);
            Log::info('User ID from request: ' . $location->user_id);
            Log::error('Error in NoticeController@storeNotice: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function show(Notice $notices, $id)
    {
        try {
            $notices = DB::table('notices')
                ->where('location_id', $id)
                ->select('notices.*', 'users.pseudo')
                ->join('users', 'notices.user_id', '=', 'users.id')
                ->get();
            
        return response()->json(['data' => $notices]);
    
        } catch (\Exception $e) {
            Log::error('Error in NoticeController@show: ' . $e->getMessage());
        }
    }
    


    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        //
    }
}
