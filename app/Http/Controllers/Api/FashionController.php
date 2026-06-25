<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fashion;
use Illuminate\Http\JsonResponse;

class FashionController extends Controller
{
    public function index(): JsonResponse
    {
        $fashion = Fashion::where('is_for_sale', true)
            ->orWhere('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($fashion);
    }

    public function featured(): JsonResponse
    {
        $featured = Fashion::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($featured);
    }

    public function show($id): JsonResponse
    {
        $fashion = Fashion::findOrFail($id);
        return response()->json($fashion);
    }
}