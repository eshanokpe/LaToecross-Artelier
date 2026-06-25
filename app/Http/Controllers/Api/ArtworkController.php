<?php

namespace App\Http\Controllers\Api;

use App\Models\Artwork;
use App\Http\Controllers\Controller;

class ArtworkController extends Controller
{
    // Get all artworks
    public function index()
    {
        $artworks = Artwork::latest()
            ->get()
            ->map(function ($artwork) {
                $artwork->image_url = asset('storage/' . $artwork->image);
                return $artwork;
            });

        return response()->json($artworks);
    }

    // Get featured artworks
    public function featured()
    {
        $artworks = Artwork::where('is_featured', true)
            ->latest()
            ->get()
            ->map(function ($artwork) {
                $artwork->image_url = asset('storage/' . $artwork->image);
                return $artwork;
            });

        return response()->json($artworks);
    }

    // Get single artwork
    public function show($id)
    {
        $artwork = Artwork::findOrFail($id);
        $artwork->image_url = asset('storage/' . $artwork->image);

        return response()->json($artwork);
    }
}