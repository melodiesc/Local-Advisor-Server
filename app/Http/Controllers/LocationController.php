<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::join('owners', 'locations.owner_id', '=', 'owners.id')
                             ->join('categories', 'locations.category_id', '=', 'categories.id')
                             ->select('locations.*', 'owners.firstname as owner_firstname', 'owners.lastname as owner_lastname', 'categories.category as category')
                             ->get();

        return response()->json(['locations' => $locations]);
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
        //
    }

    public function store(Request $request)
    {
        $location = new Location();
        $location->id = $request->id;
        $location->owner_id = $request->owner_id;
        $location->name = $request->name;
        $location->address = $request->address;
        $location->zip_code = $request->zip_code;
        $location->city = $request->city;
        $location->category_id = $request->category_id;
        $location->description = $request->description;
        $location->image_path = $request->image_path;
    
        $location->save();
    
        return response()->json($location, 201);
    }
    
    public function show($id)
{
    $location = Location::with('category', 'owner') 
                        ->where('id', $id)
                        ->first();

    if (!$location) {
        return response()->json(['message' => 'Location not found'], 404);
    }

    return response()->json($location);
}
    public function edit(Location $location)
    {
        
    }

  
    public function update(Request $request, Location $location)
    {
        
        $location->id = $request->id;
        $location->owner_id = $request->owner_id;
        $location->name = $request->name;
        $location->address = $request->address;
        $location->zip_code = $request->zip_code;
        $location->city = $request->city;
        $location->category_id = $request->category_id;
        $location->description = $request->description;
        $location->image_path = $request->image_path;
    
        $location->save();
    
        return response()->json($location);
    }
    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }
}
