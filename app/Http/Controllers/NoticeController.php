<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Notice;
use Illuminate\Http\Request;
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
    public function store(Request $request, Location $location)
    {
        try {

            $request->validate([
                'comment' => 'required',
                'rate' => 'required|numeric',
            ]);

            $notice = Notice::create([
                'location_id' => $location->id,
                'user_id' => auth()->id(),
                'comment' => $request->input('comment'),
                'rate' => $request->input('rate'),
            ]);

            $notice->save();

            return response()->json(['message' => 'Commentaire posté avec succès']);
        } catch (\Exception $e) {
            Log::error('Error in NoticeController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
