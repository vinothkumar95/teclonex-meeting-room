<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function index(): Response
    {
        
        return Inertia::render('Rooms', [
            'rooms' => Room::get(),
            'time_slots' => TimeSlot::get()
        ]);
    }

    public function bookedSlots(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
        ]);
    
        $roomId = $request->room_id;
        $date   = $request->date;
    
        $timeSlots = TimeSlot::withCount([
            'bookings as is_booked' => function($q) use ($roomId, $date) {
                $q->where('room_id', $roomId)
                  ->where('date', $date);
            }
        ])->get();
    
        return response()->json($timeSlots);
    }

    public function destroy(Booking $booking)
    {
        // Optional: Check ownership
        if ($booking->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        $booking->delete();

        return back()->with('success', 'Booking cancelled');
    }


    public function book(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required',
            'time_slot_id' => 'required',
            'date' => 'required|date',
        ]);
        
        $validated['user_id'] = $request->user()->id;

        // Prevent double booking
        $exists = Booking::where('room_id', $request->room_id)
                        ->where('time_slot_id', $request->time_slot_id)
                        ->where('date', $request->date)
                        ->exists();

        if ($exists) {
            return response()->json(['message' => 'Slot already booked'], 422);
        }

        Booking::create($validated);

        return response()->json(['success' => true]);
    }
}
