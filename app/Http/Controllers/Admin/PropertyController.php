<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('photos')->paginate(3);

        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'price' => 'required',
            'bed_rooms' => 'required|integer',
            'bath_rooms' => 'required|integer',
            'square_footage' => 'required|numeric',
            'year_built' => 'required|integer',
            'listing_status' => 'required|in:available,sold,pending',
            'date_listed' => 'required|date',
            'main_image' => 'required|image',
        ]);


        $img_name = rand() . time() . $request->file('main_image')->getClientOriginalName();
        $request->file('main_image')->move(public_path('uploads'), $img_name);


        Property::create([
            'property_type' => $request->property_type,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'price' => $request->price,
            'bed_rooms' => $request->bed_rooms,
            'bath_rooms' => $request->bath_rooms,
            'square_footage' => $request->square_footage,
            'year_built' => $request->year_built,
            'listing_status' => $request->listing_status,
            'date_listed' => $request->date_listed,
            'main_image' => $img_name,
        ]);


        return redirect()->route('admin.properties.index')
                         ->with('msg', 'Property created successfully')
                         ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Property = Property::findOrFail($id);

        return view('admin.properties.edit',compact('Property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $Property = Property::findOrFail($id);

        $img_name = $Property->image;

        if($request->hasFile('image'))
        {
            $img_name = rand().time().$request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('uploads'),$img_name);
        }

        $Property->update([
            'name' => $request->name,
            'image' => $img_name,
        ]);

        return redirect()->route('admin.properties.index')->with('msg','Property updated successfully')->with('type','info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Property = Property::findOrFail($id);
        File::delete(public_path('uploads/'.$Property->image));
        $Property->delete();

        return redirect()->route('admin.properties.index')->with('msg','Property created successfully')->with('type','danger');
    }
}
