<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork; 
use App\Models\Fashion; 
use App\Models\Article;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportTicketMail;
use App\Models\SupportTicket;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }

    public function terms(){
        return view('frontend.terms');
    }

    public function support(){
        return view('frontend.support');
    }

    public function submitSupport(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Store support ticket in database
        $ticket = SupportTicket::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending',
            'is_read' => false,
        ]); 

        // Send email notification to support team
        try {
            // $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
            // Mail::to($recipients)
            //     ->send(new SupportTicketMail($validated));
                
        } catch (\Exception $e) {
            // Log error but don't fail
            \Log::error('Failed to send support ticket email: ' . $e->getMessage());
        }

        return back()->with('support_success', 'Your support ticket has been submitted. Our team will get back to you within 24 hours.');
    }

    public function blog()
    {
        return view('frontend.blog.blog');
    }

    public function articleShow($slug)
    {
        // Find article by slug
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count (optional)
        $article->increment('views');

        // Get related articles (optional)
        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->take(3)
            ->get();

        return view('frontend.blog.blog-details', compact('article', 'relatedArticles'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function fashions()
    {
        $fashion = Fashion::all();
        return view('frontend.fashions.fashions', compact('fashion'));
    }

    public function FashionShow($id)
    {
       $fashion = Fashion::with('category')->findOrFail($id);
        
        // Get related fashions (same category, excluding current)
        $relatedFashions = Fashion::where('id', '!=', $fashion->id)
            ->where('category', $fashion->category)
            ->where('is_for_sale', true)
            ->take(4)
            ->get();

        // Get all categories for the filter
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

    public function artworks()
    {
        $artworks = Artwork::all();
        return view('frontend.artworks.artworks', compact('artworks'));
    }

    public function artworkShow($id)
    {
        // Find artwork by its slug instead of ID
        $artwork = Artwork::where('id', $id)->firstOrFail();

        return view('frontend.artworks.artwork-show', compact('artwork'));
    }
}