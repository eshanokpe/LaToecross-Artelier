<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use App\Models\Fashion;
use App\Models\Article;
use App\Models\Setting;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SupportTicketMail;
use UltraMsg\WhatsAppApi;

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
        $settings = [
            'about_content' => Setting::get('about_content'),
            'facebook_url'  => Setting::get('facebook'),
            'tiktok_url'   => Setting::get('tiktok'),
            'instagram_url' => Setting::get('instagram'),
            'linkedin_url'  => Setting::get('linkedin'),
            'youtube_url'   => Setting::get('youtube'),
            'phone'       => Setting::get('phone_1'),
            'phone_2'       => Setting::get('phone_2'),
            'email_1'       => Setting::get('email_1'),
            'email_2'       => Setting::get('email_2'),
        ];

        return view('frontend.support', compact('settings'));
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
            $recipients = array_map('trim', explode(',', config('mail.admin_alerts', 'info@latoecross.com')));
            
            Mail::to($recipients)
                ->send(new SupportTicketMail($validated));
        } catch (\Exception $e) {
            Log::error('Failed to send support ticket email: ' . $e->getMessage());
        }

        // WhatsApp notification
        try {
            $instanceId = trim(env('ULTRAMSG_INSTANCE_ID', ''));
            $token      = trim(env('ULTRAMSG_TOKEN', ''));
            $adminPhone = trim(env('ULTRAMSG_ADMIN_NUMBER', ''));

            if (empty($instanceId) || empty($token) || empty($adminPhone)) {
                Log::error('UltraMsg credentials missing in .env');
            } else {
                $api = new WhatsAppApi($token, $instanceId);

                $status = $api->getInstanceStatus();
                Log::info('UltraMsg Instance Status:', (array) $status);

                $accountStatus = data_get($status, 'status.accountStatus.status');

                if ($accountStatus === 'authenticated') {
                    $whatsappMessage = "🎫 *New Support Ticket*\n\n"
                        . "👤 *Name:* {$validated['name']}\n"
                        . "📧 *Email:* {$validated['email']}\n"
                        . "📞 *Phone:* " . ($validated['phone'] ?? 'Not provided') . "\n"
                        . "📌 *Subject:* {$validated['subject']}\n\n"
                        . "💬 *Message:*\n{$validated['message']}";

                    $response = $api->sendChatMessage($adminPhone, $whatsappMessage);
                    Log::info('UltraMsg Send Response:', (array) $response);
                } else {
                    Log::warning('UltraMsg not ready:', (array) $status);
                }
            }
        } catch (\Exception $e) {
            Log::error('Support Ticket WhatsApp Error: ' . $e->getMessage());
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
        $decryptId = decrypt($id);
        // Find artwork by its slug instead of ID
        $artwork = Artwork::where('id', $decryptId)->firstOrFail();

        return view('frontend.artworks.artwork-show', compact('artwork'));
    }
}