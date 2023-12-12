<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Location;
use App\Models\Owner;

class SearchController extends Controller
{
    public function search(Request $request, Category $category)
    {
        $searchText = $request->input('searchText');

        $result = Location::where('category_id', $category->id)
            ->join('owners', 'locations.owner_id', '=', 'owners.id')
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
            })
            ->get();

        return response()->json($result);
    }
}
