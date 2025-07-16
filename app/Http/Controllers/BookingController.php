<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::orderBy("created_at","desc")->paginate(10);
        return response()->json([
            "bookings" => $bookings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'booked_at' => 'nullable|date',
        ]);
        $validated['user_id'] = auth()->id();
        $event=Event::find($validated['event_id']);
        $bookingCounter=$event->bookings()->count();
        $alreadyBooked=Booking::where('event_id', $event->id)->where('user_id',$validated['user_id'])->exists();
        if($bookingCounter>=$event->capacity){
            return response()->json([
                  'message' => 'This event is fully booked.'
            ],403);
        }      
        if($alreadyBooked){
            return response()->json([
                'message'=> 'you already booked this event'
            ],409);
        }

        $booking = Booking::create($validated);
        return response()->json([
            "booking" => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return response()->json([
            "booking" => $booking
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
 /*    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'booked_at' => 'nullable|date',
        ]);
        $booking->update($validated);
        return response()->json([
            "booking" => $booking
        ]);
    } */

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(Booking $booking)
    {
        if(!$booking){
            return response()->json([
                "message"=> "booking not found"
            ],404);
        }
        $booking->delete();
        return response()->json([
            "message" => "Booking canceled successfully"
        ], 200);
    }
}
