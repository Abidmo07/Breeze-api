<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="Endpoints for managing event bookings (requires authentication)."
 * )
 */

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
     * @OA\Get(
     *     path="/api/bookings",
     *     tags={"Bookings"},
     *     summary="Get all bookings",
     *     description="Retrieve a paginated list of bookings for all users (admin) or the current user (if you filter logic in your code).",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of bookings",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="bookings",
     *                 type="object",
     *                 description="Paginated list of bookings"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
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
    /**
     * @OA\Post(
     *     path="/api/book",
     *     tags={"Bookings"},
     *     summary="Create a new booking for the authenticated user",
     *     description="Books an event for the logged-in user. Checks if the event is fully booked or already booked by the user.",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"event_id"},
     *             @OA\Property(property="event_id", type="integer", example=1),
     *             @OA\Property(property="booked_at", type="string", format="date", example="2025-08-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="booking", type="object")
     *         )
     *     ),
     *     @OA\Response(response=403, description="This event is fully booked."),
     *     @OA\Response(response=409, description="You already booked this event"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
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

     /**
     * @OA\Get(
     *     path="/api/bookings/{booking}",
     *     tags={"Bookings"},
     *     summary="Get a specific booking",
     *     description="Retrieve details of a single booking by its ID.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="booking",
     *         in="path",
     *         required=true,
     *         description="ID of the booking",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking details",
     *         @OA\JsonContent(
     *             @OA\Property(property="booking", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function show(Booking $booking)
    {
        return response()->json([
            "booking" => $booking
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/cancel/{booking}",
     *     tags={"Bookings"},
     *     summary="Cancel a booking",
     *     description="Cancel (delete) a booking by its ID.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="booking",
     *         in="path",
     *         required=true,
     *         description="ID of the booking to cancel",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking canceled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Booking canceled successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
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
