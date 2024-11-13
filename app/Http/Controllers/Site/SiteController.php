<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function index() {
        $properties = Property::where('listing_status', 'available')->get();
        $reviews = Review::all();

        return view('site.index',compact('properties','reviews'));
    }

    function properties() {
        $properties = Property::where('listing_status', 'available')->paginate(6);

        return view('site.properties',compact('properties'));
    }
}
