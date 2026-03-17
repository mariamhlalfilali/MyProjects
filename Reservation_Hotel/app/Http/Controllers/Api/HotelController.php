<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        return response()->json(Hotel::with('rooms')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'city'=>'required',
            'postal_code'=>'required',
            'image'=>'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('hotels','public');
        }

        $hotel = Hotel::create($data);

        return response()->json($hotel,201);
    }

    public function show($id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return response()->json($hotel);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name'=>'sometimes|required',
            'address'=>'sometimes|required',
            'city'=>'sometimes|required',
            'postal_code'=>'sometimes|required',
            'image'=>'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            if($hotel->image){
                Storage::disk('public')->delete($hotel->image);
            }
            $data['image'] = $request->file('image')->store('hotels','public');
        }

        $hotel->update($data);

        return response()->json($hotel);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        if($hotel->image){
            Storage::disk('public')->delete($hotel->image);
        }
        $hotel->delete();
        return response()->json(['message'=>'Hotel deleted']);
    }
}