<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Location;

class SearchController extends Controller
{
    public function search(Request $request, $category)
    {
        $searchText = $request->input('searchText');
    
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
    
        if ($category === 'all') {
            $query->whereIn('locations.category_id', [1, 2, 3]);
        } else {
            $categoryId = (int)$category;
            $query->where('locations.category_id', $categoryId);
        }
    
        $result = $query->get();
    
        return response()->json($result);
    }
    
}
