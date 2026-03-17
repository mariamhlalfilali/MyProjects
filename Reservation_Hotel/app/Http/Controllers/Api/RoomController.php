<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
 public function index($hotelId = null)
{
    $query = Room::with('hotel');
    if ($hotelId) {
        $query->where('hotel_id', $hotelId);
    }
    return response()->json($query->get());
}

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id'=>'required|exists:hotels,id',
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric',
            'capacity'=>'required|integer',
            'image'=>'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('rooms','public');
        }

        $room = Room::create($data);

        return response()->json($room,201);
    }

    public function show($id)
    {
        $room = Room::with('hotel')->findOrFail($id);
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'hotel_id'=>'sometimes|required|exists:hotels,id',
            'name'=>'sometimes|required',
            'description'=>'nullable',
            'price'=>'sometimes|required|numeric',
            'capacity'=>'sometimes|required|integer',
            'image'=>'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            if($room->image){
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms','public');
        }

        $room->update($data);

        return response()->json($room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if($room->image){
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();
        return response()->json(['message'=>'Room deleted']);
    }
}