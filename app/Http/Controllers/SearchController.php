<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Location;

class SearchController extends Controller
{
    public function search(Request $request, $category)
    {
        // Récupération du texte de recherche depuis la requête
        $searchText = $request->input('searchText');

        // Construction de la requête pour récupérer les emplacements en fonction du texte de recherche et éventuellement de la catégorie
        $query = Location::join('owners', 'locations.owner_id', '=', 'owners.id')
            ->join('categories', 'locations.category_id', '=', 'categories.id')
            ->select(
                'locations.*',
                'owners.lastname as owner_lastname',
                'owners.firstname as owner_firstname',
                'categories.category'
            )
            ->where(function ($query) use ($searchText) {
                $query->where('locations.name', 'like', "%$searchText%")
                    ->orWhere('locations.address', 'like', "%$searchText%")
                    ->orWhere('locations.zip_code', 'like', "%$searchText%")
                    ->orWhere('locations.city', 'like', "%$searchText%")
                    ->orWhere('owners.lastname', 'like', "%$searchText%")
                    ->orWhere('owners.firstname', 'like', "%$searchText%")
                    ->orWhere('categories.category', 'like', "%$searchText%");
            });

        // Filtrage supplémentaire en fonction de la catégorie
        if ($category === 'all') {
            // Si la catégorie est 'all', inclure les emplacements de toutes les catégories (1, 2, 3)
            $query->whereIn('locations.category_id', [1, 2, 3]);
        } else {
            // Sinon, filtrer les emplacements par la catégorie spécifiée
            $categoryId = (int)$category;
            $query->where('locations.category_id', $categoryId);
        }

        // Exécution de la requête et récupération des résultats
        $result = $query->get();

        // Retour d'une réponse JSON contenant les résultats de la recherche
        return response()->json($result);
    }

    
}
