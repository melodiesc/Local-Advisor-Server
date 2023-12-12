<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Location;

class SearchController extends Controller
{
    public function search(Request $request, Category $category)
    {
        $searchText = $request->input('searchText');

        $result = Location::where('category_id', $category->id)
            ->where(function ($query) use ($searchText) {
                $query->where('name', 'like', "%$searchText%")
                        ->orWhere('address', 'like', "%$searchText%")
                        ->orWhere('city', 'like', "%$searchText%");
            })
            ->get();

        return response()->json($result);
    }
}