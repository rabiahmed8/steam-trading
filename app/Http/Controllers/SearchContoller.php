<?php

namespace App\Http\Controllers;

use App\Models\SteamMarketItem;
use Illuminate\Http\Request;

class SearchContoller extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // $results = SteamMarketItem::where('name', 'like', $query.'%')->take(10)->get();

        $results = SteamMarketItem::select('name', 'icon')->where('name', 'like', '%' . $query . '%')->take(10)->get();


        return response()->json($results);
    }
}
