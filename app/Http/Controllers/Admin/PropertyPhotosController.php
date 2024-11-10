<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PropertyPhotosController extends Controller
{
    public function index()
    {
        $photos = PropertyPhoto::paginate(5);

        return view('admin.property_photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::all();

        return view('admin.property_photos.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'photo_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
            $img_name = time() . '_' . $request->file('photo_path')->getClientOriginalName();
            $request->file('photo_path')->move(public_path('uploads/property_photos'), $img_name);

            PropertyPhoto::create([
                'property_id' => $request->property_id,
                'photo_path' => 'uploads/property_photos/' . $img_name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.property_photos.index')->with('msg', 'Photo added successfully')->with('type', 'success');
        }

        return back()->withErrors('Failed to upload the photo. Please try again.');
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
        $photo = PropertyPhoto::findOrFail($id);
        $properties = Property::all();

        return view('admin.property_photos.edit', compact('photo', 'properties'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'photos_type' => 'required',
        ]);

        $photos = PropertyPhoto::findOrFail($id);

        $img_name = $photos->main_image;

        if($request->hasFile('main_image'))
        {
            $img_name = rand().time().$request->file('main_image')->getClientOriginalName();

            $request->file('main_image')->move(public_path('uploads'),$img_name);
        }

        $photos->update([
            'photos_type' => $request->photos_type,
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

        return redirect()->route('admin.property_photos.index')->with('msg','PropertyPhoto updated successfully')->with('type','info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photos = PropertyPhoto::findOrFail($id);
        File::delete(public_path('uploads/'.$photos->image));
        $photos->delete();

        return redirect()->route('admin.property_photos.index')->with('msg','PropertyPhoto created successfully')->with('type','danger');
    }
}
