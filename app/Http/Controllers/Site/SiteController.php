<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function index() {
        $properties = Property::where('listing_status', 'available')->get();

        return view('site.index',compact('properties'));
    }
}
