<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    // GET /api/studios
    public function index()
    {
        return response()->json(Studio::all());
    }

    // POST /api/studios
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $studio = Studio::create($request->all());

        return response()->json([
            'message' => 'Studio created successfully',
            'data' => $studio
        ], 201);
    }

    // GET /api/studios/{id}
    public function show($id)
    {
        $studio = Studio::findOrFail($id);
        return response()->json($studio);
    }

    // PUT /api/studios/{id}
    public function update(Request $request, $id)
    {
        $studio = Studio::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $studio->update($request->all());

        return response()->json([
            'message' => 'Studio updated successfully',
            'data' => $studio
        ]);
    }

    // DELETE /api/studios/{id}
    public function destroy($id)
    {
        Studio::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Studio deleted successfully'
        ]);
    }
}
