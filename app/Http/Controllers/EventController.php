<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
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
    public function show(Event $event)
    {
        return response()->json([
            "event" => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
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
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            "message" => "Event deleted successfully"
        ], 204);
    }
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
