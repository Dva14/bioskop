<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    // GET /api/films
    public function index()
    {
        return response()->json(Film::all());
    }

    // POST /api/films
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'genre' => 'nullable|string',
            'duration' => 'required|integer',
        ]);

        $film = Film::create($request->all());

        return response()->json([
            'message' => 'Film created',
            'data' => $film
        ], 201);
    }
}
