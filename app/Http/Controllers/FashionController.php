<?php

namespace App\Http\Controllers;

use App\Models\Fashion;
use Illuminate\Http\Request;

class FashionController extends Controller
{
    /**
     * Display a listing of the fashions.
     */
    public function index()
    {
        return view('frontend.fashions.fashions');
    }

    /**
     * Display the specified fashion.
     */
    public function show($id)
    {
        $decryptId = decrypt($id);
        // Get the fashion item
        $fashion = Fashion::findOrFail($decryptId);
        
        // Get related fashions (same category, excluding current)
        $relatedFashions = Fashion::where('id', '!=', $fashion->id)
            ->where('category', $fashion->category)
            ->where('is_for_sale', true)
            ->take(4)
            ->get();

        // Categories array for display
        $categories = [
            'all' => 'All Fashion',
            'men' => "Men's Wear",
            'ladies' => 'Ladies Wear',
            'unisex' => 'Unisex',
            'kids' => "Kids Wear",
            'painting_on_wear' => 'Painting on Wears',
            'fabric' => 'Fabric',
            'asooke' => 'Asooke',
            'etc' => 'Others',
        ];

        return view('frontend.fashions.fashion-details', compact(
            'fashion', 
            'relatedFashions', 
            'categories'
        ));
    }

    /**
     * Display fashions by category.
     */
    public function byCategory($category)
    {
        $fashions = Fashion::where('category', $category)
            ->where('is_for_sale', true)
            ->paginate(12);
            
        return view('frontend.fashions.fashions', compact('fashions'));
    }
}