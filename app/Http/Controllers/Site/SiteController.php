<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function index()
    {
        $properties = Property::where('listing_status', 'available')->get();
        $reviews = Review::all();

        return view('site.index', compact('properties', 'reviews'));
    }

    function properties()
    {
        $properties = Property::where('listing_status', 'available')->paginate(6);

        return view('site.properties', compact('properties'));
    }

    function search_properties(Request $request)
    {
        $query = $request->input('query');

        $properties = Property::where('listing_status', 'available');

        if ($query) {
            $properties->where(function ($q) use ($query) {
                $q->where('city', 'like', '%' . $query . '%')
                    ->orWhere('zip_code', 'like', '%' . $query . '%');
            });
        }

        $properties = $properties->paginate(9);

        return view('site.search_properties', compact('properties'));
    }


    function show($id)
    {
        $property = Property::with('photos')->findOrFail($id);

        return view('site.property-single', compact('property'));
    }
}
