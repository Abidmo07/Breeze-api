<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Event",
 *     type="object",
 *     required={"title", "start_time", "location", "capacity"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Laravel Conference 2025"),
 *     @OA\Property(property="description", type="string", example="A conference about Laravel and PHP."),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2025-09-01T10:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2025-09-01T18:00:00Z"),
 *     @OA\Property(property="location", type="string", example="Algiers, Algeria"),
 *     @OA\Property(property="capacity", type="integer", example=200),
 *     @OA\Property(property="image_url", type="string", format="url", example="https://example.com/image.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Event extends Model
{
    protected $fillable = [
        "title",
        "description",
        "start_time",
        "end_time",
        "capacity",
        "location",
        "image_url",
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
