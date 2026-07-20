<?php

use App\Models\Category;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Http; // ✅ Added for Wasender API
use Illuminate\Support\Facades\Log;

new class extends Component
{
    public $email = '';
    public $showSuccess = false;
    public $errorMessage = null;
    public $categories;
    public $settings;
 
    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email address is too long.',
    ];

    public function mount(): void
    {
        // Get active categories
        $this->categories = Category::where('is_active', true)->take(6)->get();

        // Get all settings in one go
        $this->settings = [
            'about_content' => Setting::get('about_content'),
            'facebook_url'  => Setting::get('facebook'),
            'tiktok_url'   => Setting::get('tiktok'),
            'instagram_url' => Setting::get('instagram'),
            'linkedin_url'  => Setting::get('linkedin'),
            'youtube_url'   => Setting::get('youtube'),
            'phone_1'       => Setting::get('phone_1'),
            'phone_2'       => Setting::get('phone_2'),
            'email_1'       => Setting::get('email_1'),
            'email_2'       => Setting::get('email_2'),
        ];
    }

    public function subscribe()
    {
        $this->validate();

        try {
            // ✅ WASNDER API CONFIGURATION
            // Add these to your .env file:
            // WASENDER_API_URL=https://wasenderapi.com/api/send-message
            // WASENDER_BEARER_TOKEN=9b2c787349d305f72c0fc247f37e25684bbfac4af87ce195e042a4d729dd9eb1
            // WASENDER_ADMIN_PHONE=+1234567890
            
            $apiUrl     = config('services.wasender.api_url');
            $token      = config('services.wasender.bearer_token');
            $adminPhone = config('services.wasender.admin_phone');

            if (!empty($apiUrl) && !empty($token) && !empty($adminPhone)) {
                // ✅ FORMAT MESSAGE FOR WHATSAPP
                $whatsappMessage = "📧 *New Newsletter Subscription*\n\n"
                    . "👤 *Email:* {$this->email}\n"
                    . "📅 *Date:* " . now()->format('M d, Y h:i A');

                // ✅ SEND REQUEST USING LARAVEL HTTP CLIENT (Matches your cURL)
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ])->post($apiUrl, [
                    'to'   => $adminPhone,
                    'text' => $whatsappMessage
                ]);

                if ($response->successful()) {
                    Log::info('Newsletter WhatsApp Alert Sent:', ['email' => $this->email]);
                } else {
                    Log::warning('Newsletter WhatsApp Alert Failed:', [
                        'status' => $response->status(),
                        'body'   => $response->body()
                    ]);
                }
            } else {
                Log::warning('Wasender credentials missing for newsletter alert.');
            }

            // ✅ Show Success UI
            $this->showSuccess = true;
            $this->email = '';
            
            // Reset success message after 5 seconds
            $this->dispatch('reset-success', delay: 5000);

        } catch (\Exception $e) {
            Log::error('Newsletter Subscribe Error: ' . $e->getMessage());
            // Still show success to user even if WhatsApp fails, 
            // or set $this->errorMessage = "Subscription failed.";
            $this->showSuccess = true;
            $this->email = '';
        }
    }
}; 
?>

<div class="footer-section-wrapper">
    <!-- Footer Section -->
    <footer class="footer-section" style="background: linear-gradient(180deg, #1a0a0f 0%, #2d1520 50%, #1a0a0f 100%);">
        <div class="container mx-auto px-4">
            <!-- Main Footer Content -->
            <div class="footer-menu-wrap py-12 md:py-16">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <!-- Column 1: Brand Info -->
                    <div class="lg:col-span-1">
                        <div class="footer-content-area space-y-4">
                            <!-- Logo -->
                            <a href="{{ route('home') }}" class="footer-logo inline-block">
                                <img src="{{ asset('images/logo.png') }}" 
                                     alt="Latocross Artelier" 
                                     style="width:100px"
                                    >
                            </a>

                            <!-- About Text -->
                            <p class="text-sm leading-relaxed" style="color: #cdb4c8; ">
                                {!! Str::limit(nl2br($settings['about_content']) ?? 'An Art Action Company typically operates in the space of live art, performance, and social practice, often combining elements of activism and community engagement.', 175) !!}
                                @if(strlen(trim(strip_tags($settings['about_content'] ?? ''))) > 120)
                                    <a href="{{ route('about') }}" class="font-medium hover:underline ml-1" style="color: #DB2077;">
                                        Read More
                                    </a>
                                @endif
                            </p>

                            <!-- Contact Info -->
                            <div class="space-y-1.5">
                                @if(!empty($settings['phone_1']))
                                    <div class="flex items-center gap-3 text-sm" style="color: #cdb4c8;">
                                        <svg class="w-4 h-4 flex-shrink-0" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span>
                                            {{ $settings['phone_1'] }}
                                            @if(!empty($settings['phone_2']))
                                                <span class="text-xs opacity-60">/ {{ $settings['phone_2'] }}</span>
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                @if(!empty($settings['email_1']))
                                    <div class="flex items-center gap-3 text-sm" style="color: #cdb4c8;">
                                        <svg class="w-4 h-4 flex-shrink-0" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span>
                                            {{ $settings['email_1'] }}
                                            @if(!empty($settings['email_2']))
                                                <span class="text-xs opacity-60">/ {{ $settings['email_2'] }}</span>
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Social Links -->
                            <div class="flex flex-wrap gap-2 pt-2">
                               <!-- Social Links -->

                                @if(!empty($settings['facebook_url']))
                                    <a href="{{ $settings['facebook_url'] }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                    style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        <span class="sr-only">Facebook</span>
                                    </a>
                                @endif


                                @if(!empty($settings['instagram_url']))
                                    <a href="{{ $settings['instagram_url'] }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                       style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                        <span class="sr-only">Instagram</span>
                                    </a>
                                @endif
                                @if(!empty($settings['tiktok_url']))
                                    <a href="{{ $settings['tiktok_url'] }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                    style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.11-.59-1.62-.93-.01 2.92.01 5.84-.02 8.76-.08 1.4-.54 2.79-1.35 3.99-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                        </svg>
                                        <span class="sr-only">TikTok</span>
                                    </a>
                                @endif
                                @if(!empty($settings['twitter_url']))
                                    <a href="{{ $settings['twitter_url'] }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                       style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                        <span class="sr-only">Twitter/X</span>
                                    </a>
                                @endif
                                @if(!empty($settings['linkedin_url']))
                                    <a href="{{ $settings['linkedin_url'] }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                       style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                        <span class="sr-only">LinkedIn</span>
                                    </a>
                                @endif
                                @if(!empty($settings['youtube_url']))
                                    <a href="{{ $settings['youtube_url'] }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                       style="background: rgba(255, 255, 255, 0.08); color: #cdb4c8;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        <span class="sr-only">YouTube</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="lg:col-span-1">
                        <div class="footer-widget">
                            <h5 class="text-white font-bold text-lg mb-4" style="font-family: 'Georgia', serif;">Quick Links</h5>
                            <ul class="space-y-2.5">
                                <li>
                                    <a href="{{ route('artworks.index') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Art Catalog
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('fashions.index') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Fashion Catalog
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Contact
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Column 3: Resources -->
                    <div class="lg:col-span-1">
                        <div class="footer-widget">
                            <h5 class="text-white font-bold text-lg mb-4" style="font-family: 'Georgia', serif;">Resources</h5>
                            <ul class="space-y-2.5">
                                <li>
                                    <a href="{{ route('blog') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('faq') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> F.A.Q
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('support') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Support Center
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('terms') }}" 
                                       class="text-sm transition-all duration-300 hover:pl-2 inline-block"
                                       style="color: #cdb4c8;">
                                        <span style="color: #DB2077;">›</span> Terms & Conditions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Column 4: Newsletter -->
                    <div class="lg:col-span-1">
                        <div class="newsletter-area">
                            <h5 class="text-white font-bold text-lg mb-2" style="font-family: 'Georgia', serif;">
                                Join Our Newsletter
                            </h5>
                            <p class="text-sm mb-4" style="color: #cdb4c8;">
                                Get exclusive art updates, behind-the-scenes content, and special offers.
                            </p>

                            <!-- Success Message -->
                            @if($showSuccess)
                                <div class="mb-4 p-3 rounded-xl flex items-start gap-3" 
                                     style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3);">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium" style="color: #86efac;">Subscribed!</p>
                                        <p class="text-xs" style="color: #86efac;">Thank you for subscribing.</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Subscribe Form -->
                            <form wire:submit.prevent="subscribe" class="space-y-3">
                                <div class="relative">
                                    <input type="email" 
                                           wire:model="email" 
                                           placeholder="Enter your email"
                                           class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2 text-sm"
                                           style="border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white;"
                                           wire:focus="border-color: #DB2077; ring-color: #DB2077;">
                                    <button type="submit" 
                                            wire:loading.attr="disabled"
                                            class="absolute right-1.5 top-1/2 transform -translate-y-1/2 p-2 rounded-lg transition-all duration-300 hover:scale-105"
                                            style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                        <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                        <svg wire:loading class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('email')
                                    <p class="text-xs" style="color: #f87171;">{{ $message }}</p>
                                @enderror
                            </form>

                            <!-- Trust Badges -->
                            <div class="mt-4 flex items-center gap-4 text-xs" style="color: #6b3b4f;">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    No spam
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Unsubscribe anytime
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom py-6 border-t flex flex-col md:flex-row items-center justify-between gap-4" style="border-color: rgba(255,255,255,0.08);">
                <div class="copyright-area">
                    <p class="text-xs" style="color: #6b3b4f;">
                        © {{ date('Y') }} 
                        <a href="{{ route('home') }}" class="hover:underline" style="color: #DB2077;">
                            Latocross Artelier
                        </a>
                        <span class="mx-2 opacity-30">|</span>
                        Design by 
                        <a href="#" class="hover:underline" style="color: #DB2077;">
                            Latocross Artelier
                        </a>
                    </p>
                </div>
                <div class="footer-bottom-right">
                    <ul class="flex flex-wrap items-center gap-4 text-xs">
                        <li>
                            <a href="{{ route('support') }}" class="hover:underline" style="color: #6b3b4f;">
                                Support Center
                            </a>
                        </li>
                        <li class="opacity-30" style="color: #6b3b4f;">|</li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:underline" style="color: #6b3b4f;">
                                Terms & Conditions
                            </a>
                        </li>
                        <li class="opacity-30" style="color: #6b3b4f;">|</li>
                        <li>
                            <a href="{{ route('privacy') }}" class="hover:underline" style="color: #6b3b4f;">
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .footer-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        /* Hover effects */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:scale-110:hover {
            transform: scale(1.1);
        }

        .hover\:pl-2:hover {
            padding-left: 0.5rem;
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Input focus */
        input:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.15) !important;
        }

        /* Social icons hover */
        .social-icon:hover {
            background: linear-gradient(135deg, #DB2077, #ff6b9d) !important;
            color: white !important;
        }

        /* Loading spinner */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Newsletter input placeholder */
        input::placeholder {
            color: #6b3b4f;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .footer-menu-wrap {
                padding: 2rem 0;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .footer-bottom-right ul {
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .footer-content-area {
                text-align: center;
            }

            .footer-content-area .flex {
                justify-content: center;
            }

            .footer-widget {
                text-align: center;
            }

            .newsletter-area {
                text-align: center;
            }

            .footer-bottom-right ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
            }

            .footer-bottom-right ul li:not(:last-child)::after {
                content: '|';
                margin-left: 0.5rem;
                opacity: 0.3;
                color: #6b3b4f;
            }
        }

        /* Print styles */
        @media print {
            .footer-section {
                background: #1a0a0f !important;
                color: white !important;
            }
            
            .newsletter-area {
                display: none;
            }
        }

        /* Focus styles for accessibility */
        a:focus-visible,
        button:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }
    </style>
</div>