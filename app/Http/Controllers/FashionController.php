<?php

namespace App\Http\Controllers;

use App\Models\Fashion;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

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
        $decodedIds = Hashids::decode($id);
        abort_if(empty($decodedIds), 404);

        $fashion = Fashion::findOrFail($decodedIds[0]);
        
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