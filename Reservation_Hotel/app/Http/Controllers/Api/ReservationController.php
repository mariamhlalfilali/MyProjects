<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReservationConfirmedMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 🔹 Liste des réservations
    public function index()
    {
        $user = Auth::user();

        // Si admin → voir toutes les réservations
        if ($user->role === 'admin') {
            $reservations = Reservation::with(['user', 'room.hotel'])->latest()->get();
        } else {
            // Sinon → voir seulement ses réservations
            $reservations = Reservation::with(['room.hotel'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
     // 🔹 Créer réservation
    public function store(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in'
        ]);

        $room = Room::findOrFail($request->room_id);

        if (!$room->isAvailable($request->check_in, $request->check_out)) {
            return response()->json([
                'message' => 'Room not available for selected dates'
            ], 409);
        }

        $days = Carbon::parse($request->check_in)
            ->diffInDays(Carbon::parse($request->check_out));

        $total = $days * $room->price;

        $reservation = Reservation::create([
            'user_id'     => Auth::id(),
            'room_id'     => $room->id,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'total_price' => $total,
            'status'      => 'confirmed'
        ]);
        Mail::to(Auth::user()->email)
                ->queue(new ReservationConfirmedMail(
                    $reservation->load('user','room.hotel')
                ));
                
        return response()->json([
            'message' => 'Reservation created successfully',
            'data'    => $reservation->load('room.hotel')
        ], 201);

          
    }


    
    public function show($id)
    {
        $reservation = Reservation::with(['room.hotel', 'user'])
            ->findOrFail($id);

        if (Auth::user()->role !== 'admin' &&
            $reservation->user_id !== Auth::id()) {

            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($reservation);
    }


    
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $reservation->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Reservation updated',
            'data'    => $reservation
        ]);
    }

   
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }
}
