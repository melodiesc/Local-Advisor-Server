<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function index()
    {
        // Requête SQL pour récupérer des informations sur les emplacements, les propriétaires et les catégories
        $locations = Location::join('owners', 'locations.owner_id', '=', 'owners.id')
                            ->join('categories', 'locations.category_id', '=', 'categories.id')
                            ->select('locations.*', 'owners.firstname as owner_firstname', 'owners.lastname as owner_lastname', 'categories.category as category')
                            ->get();

        // Transformation des chemins d'image en URL complet
        $locations = $locations->map(function ($location) {
            $location->image_path = asset($location->image_path);
            return $location;
        });

        // Retourne les données formatées en tant que réponse JSON
        return response()->json(['locations' => $locations]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'owner_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'zip_code' => 'required|numeric',
            'city' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Récupération de l'image depuis la requête
        $image = $request->file('image_path');

        // Vérification de la taille de l'image
        $sizeInKb = $image->getSize() / 1024;
        if ($sizeInKb > 2048) {
            return response()->json(['error' => 'L\'image est trop volumineuse, elle ne doit pas dépasser 2 Mo.'], 400);
        }

        // Récupération du nom d'origine, de l'extension et vérification de l'extension
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return response()->json(['error' => 'Format d\'image non pris en charge. Utilisez des images au format : jpg, jpeg, png ou gif.'], 400);
        }

        // Création d'un nom d'image unique basé sur le timestamp et le nom d'origine
        $imageName = time() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

        // Stockage de l'image dans le dossier 'images' avec un nom unique
        $image_path = $image->storeAs('images', $imageName, 'public');

        // Déplacement de l'image vers le dossier public/images (peut être redondant avec le stockage ci-dessus)
        $image->move(public_path('images'), $imageName);

        // Création d'une nouvelle instance de Location dans la base de données
        $location = Location::create([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image_path' => $image_path,
        ]);

        // Retour d'une réponse JSON avec la location créée et le code de statut 201 (Created)
        return response()->json($location, 201);
    }


    public function show($id)
    {
        // Récupération de la location avec les relations "category" et "owner"
        $location = Location::with('category', 'owner')
                            ->where('id', $id)
                            ->first();

        // Ajout du chemin complet de l'image à l'URL pour l'affichage
        $location->image_path = asset($location->image_path);

        // Vérification si la location existe
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        // Retour d'une réponse JSON avec les détails de la location
        return response()->json($location);
    }


        
    public function edit(Location $location)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'owner_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'zip_code' => 'required|numeric',
            'city' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
    
        // Recherche de la location à mettre à jour par son identifiant
        $location = Location::find($id);
    
        // Vérification si la location existe
        if (!$location) {
            return response()->json(['message' => 'Aucun lieu trouvé à cet ID'], 404);
        }
    
        // Mise à jour des attributs de la location avec les données fournies dans la requête
        $location->update([
            'owner_id' => $request->owner_id,
            'name' => $request->name,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
    
        // Retour d'une réponse JSON indiquant que la mise à jour a été effectuée avec succès
        return response()->json(['message' => 'Lieu mis à jour avec succès']);
    }
    

    public function destroy($id)
    {
        // Recherche de la location à supprimer par son identifiant
        $location = Location::find($id);

        // Vérification si la location existe
        if (!$location) {
            return response()->json(['message' => 'Aucun lieu trouvé à cet ID'], 404);
        }

        // Suppression de la location
        $location->delete();

        // Retour d'une réponse JSON indiquant que la suppression a été effectuée avec succès
        return response()->json(['message' => 'Lieu supprimé avec succès']);
    }

}
