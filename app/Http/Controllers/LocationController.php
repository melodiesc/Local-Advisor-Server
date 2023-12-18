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
        $request->validate([
            'owner_id'=> 'required',
            'name'=> 'required',
            'address'=> 'required',
            'zip_code'=> 'required|numeric',
            'city'=> 'required',
            'category_id'=> 'required',
            'description'=> 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $image = $request->file('image_path');
    
        $sizeInKb = $image->getSize() / 1024;
        if ($sizeInKb > 2048) {
            return response()->json(['error' => 'L\'image est trop volumineuse, elle ne doit pas dépasser 2 Mo.'], 400);
        }
    
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return response()->json(['error' => 'Format d\'image non pris en charge. Utilisez des images au format : jpg, jpeg, png ou gif.'], 400);
        }
    
        $imageName = time() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $image_path = $image->storeAs('images', $imageName, 'public');
        $image->move(public_path('images'), $imageName);


        $location = Location::create([
            'owner_id'=> $request->owner_id,
            'name'=> $request->name,
            'address'=> $request->address,
            'zip_code'=> $request->zip_code,
            'city'=> $request->city,
            'category_id'=> $request->category_id,
            'description'=> $request->description,
            'image_path' => $image_path,
        ]);


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
