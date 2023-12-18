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

        // Modifier le chemin de l'image pour renvoyer l'URL complet
        $locations = $locations->map(function ($location) {
        $location->image_path = asset($location->image_path);
        return $location;
    });
        return response()->json(['locations' => $locations]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $image = $request->file('image_path');
        $originalName = $image->getClientOriginalName();
        $extension =$image->getClientOriginalExtension();
        $imageName = time() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $image_path = $image->storeAs( 'images', $imageName,'public' );
        $request->image_path->move(public_path('images'), $imageName);

        $location = new Location();
        $location->id = $request->id;
        $location->owner_id = $request->owner_id;
        $location->name = $request->name;
        $location->address = $request->address;
        $location->zip_code = $request->zip_code;
        $location->city = $request->city;
        $location->category_id = $request->category_id;
        $location->description = $request->description;
        $location->image_path = $image_path;
        $location->save();



        return response()->json($location, 201);
    }
    public function show($id)
{
    $location = Location::with('category', 'owner') 
                        ->where('id', $id)
                        ->first();

    $location->image_path = asset($location->image_path);

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
