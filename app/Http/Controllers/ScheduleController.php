<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // GET /api/schedules
    public function index()
    {
        return response()->json(
            Schedule::with(['film', 'studio'])->get()
        );
    }

    // POST /api/schedules
    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id'   => 'required|exists:films,id',
            'studio_id' => 'required|exists:studios,id',
            'show_date' => 'required|date',
            'show_time' => 'required|date_format:H:i',
            'price'     => 'required|integer|min:0',
        ]);

        $schedule = Schedule::create([
            'film_id'   => $validated['film_id'],
            'studio_id' => $validated['studio_id'],
            'show_date' => $validated['show_date'],
            'show_time' => $validated['show_time'],
            'price'     => $validated['price'],
        ]);

        return response()->json([
            'message' => 'Schedule created successfully',
            'data'    => $schedule
        ], 201);
    }

    // GET /api/schedules/{id}
    public function show($id)
    {
        return response()->json(
            Schedule::with(['film', 'studio'])->findOrFail($id)
        );
    }

    // PUT /api/schedules/{id}
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'film_id'   => 'sometimes|exists:films,id',
            'studio_id' => 'sometimes|exists:studios,id',
            'show_date' => 'sometimes|date',
            'show_time' => 'sometimes|date_format:H:i',
            'price'     => 'sometimes|integer|min:0',
        ]);

        $schedule->update($validated);

        return response()->json([
            'message' => 'Schedule updated',
            'data' => $schedule
        ]);
    }

    // DELETE /api/schedules/{id}
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Schedule deleted'
        ]);
    }
}
