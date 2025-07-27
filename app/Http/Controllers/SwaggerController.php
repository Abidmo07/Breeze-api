<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Event Booking API",
 *         version="1.0.0",
 *         description="API documentation for Event, Booking, and Auth management with authentication.",
 *         @OA\Contact(email="support@example.com"),
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000/",
 *         description="Local API Server"
 *     ),
 *
 *     @OA\Tag(
 *         name="Auth",
 *         description="Authentication related endpoints (Login, Register, Logout, User)."
 *     ),
 *     @OA\Tag(
 *         name="Events",
 *         description="Endpoints for managing events."
 *     ),
 *     @OA\Tag(
 *         name="Bookings",
 *         description="Endpoints for managing bookings."
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class SwaggerController extends Controller
{
    // This class is only for Swagger annotations
}
