<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use OpenApi\Annotations\OpenApi;
/**
 * @OA\Tag(
 *   name="Events",
 *   description="Endpoints for managing events"
 * )
 */


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/api/events",
 *     tags={"Events"},
 *     summary="Get a paginated list of events",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of events",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="events", type="array", @OA\Items(ref="#/components/schemas/Event"))
 *         )
 *     )
 * )
 */

    public function index()
    {
        $events = Event::orderBy("created_at", "desc")->paginate(10);
        return response()->json([
            "events" => $events
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
      /**
     * @OA\Post(
     *     path="/api/event",
     *     tags={"Events"},
     *     summary="Create a new event",
     *     security={{"sanctum":{}, "role:admin":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","start_time","location","capacity"},
     *             @OA\Property(property="title", type="string", example="Laravel Conference 2025"),
     *             @OA\Property(property="description", type="string", example="A conference about Laravel and PHP."),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-09-01T10:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2025-09-01T18:00:00Z"),
     *             @OA\Property(property="location", type="string", example="Algiers, Algeria"),
     *             @OA\Property(property="capacity", type="integer", example=200),
     *             @OA\Property(property="image_url", type="string", example="https://example.com/event.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="event", ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image_url' => 'nullable|url',
        ]);
        $event = Event::create($validated);
        return response()->json([
            "event" => $event
        ], 201);
    }

    /**
     * Display the specified resource.
     */

     /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Get details of a specific event",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the event",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="event", ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Event not found")
     * )
     */
    public function show(Event $event)
    {
        return response()->json([
            "event" => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

     /**
     * @OA\Put(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Update an existing event",
     *     security={{"sanctum":{}, "role:admin":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the event",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Event Title"),
     *             @OA\Property(property="description", type="string", example="Updated event details."),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-08-21T10:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2025-08-21T18:00:00Z"),
     *             @OA\Property(property="location", type="string", example="Oran, Algeria"),
     *             @OA\Property(property="capacity", type="integer", example=120),
     *             @OA\Property(property="image_url", type="string", example="https://example.com/updated.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="event", ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Event not found")
     * )
     */
    public function update(Request $request, Event $event)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image_url' => 'nullable|url',
        ]);
        $event->update($validated);
        return response()->json([
            "event" => $event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

      /**
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Delete an event",
     *     security={{"sanctum":{}, "role:admin":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the event",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=204, description="Event deleted successfully"),
     *     @OA\Response(response=404, description="Event not found")
     * )
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            "message" => "Event deleted successfully"
        ], 204);
    }

      /**
     * @OA\Get(
     *     path="/api/events/search",
     *     tags={"Events"},
     *     summary="Search events by title, description, or location",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         description="Filter events by title",
     *         @OA\Schema(type="string", example="Conference")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         required=false,
     *         description="Filter events by description",
     *         @OA\Schema(type="string", example="Laravel")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         required=false,
     *         description="Filter events by location",
     *         @OA\Schema(type="string", example="Algiers")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of filtered events",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="events", type="array", @OA\Items(ref="#/components/schemas/Event"))
     *         )
     *     )
     * )
     */
    public function search( Request $request )
    {
        $event=Event::query();
        if( $request->has("title") ){
            $event->where("title","like","%".$request->get("title")."%");
        }
        if( $request->has("description") ){
            $event->Where("description","like","%".$request->get("description")."%");
        }
        if( $request->has("location") ){
            $event->Where("location","like","%".$request->get("location")."%");
        }
        return response()->json([
            "events" => $event->orderBy("created_at", "desc")->paginate(10)
        ]);
    }
}
