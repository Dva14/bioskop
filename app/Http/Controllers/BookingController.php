<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookingController extends Controller
{
    // GET /api/bookings (booking user login)
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(
            Booking::with('schedule.film', 'schedule.studio')
                ->where('user_id', $user->id)
                ->get()
        );
    }

    // POST /api/bookings
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_count' => 'required|integer|min:1'
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        $totalPrice = $schedule->price * $request->seat_count;

        $booking = Booking::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'seat_count' => $request->seat_count,
            'total_price' => $totalPrice
        ]);

        return response()->json([
            'message' => 'Booking successful',
            'data' => $booking
        ], 201);
    }

    // GET /api/bookings/{id}
    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $booking = Booking::with('schedule.film', 'schedule.studio')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return response()->json($booking);
    }

    // DELETE /api/bookings/{id}
    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $booking = Booking::where('user_id', $user->id)
            ->findOrFail($id);

        $booking->delete();

        return response()->json([
            'message' => 'Booking cancelled'
        ]);
    }
}
