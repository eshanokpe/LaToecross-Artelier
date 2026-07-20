<?php

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\Http; // ✅ Added for Wasender API
use Illuminate\Support\Facades\Log;
 
new class extends Component
{
    public $articles = [];
    public $currentPage = 1;
    public $itemsPerPage = 6;
    public $lastPage = 1;
    
    // ✅ Newsletter Subscription Properties
    public $newsletterEmail = '';
    public $showSubSuccess = false;

    public function mount()
    {
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $paginated = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);

        $this->articles = $paginated->items();
        $this->lastPage = $paginated->lastPage();
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;
        $this->loadArticles();
        $this->dispatch('page-changed');
    }

    public function prevPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadArticles();
            $this->dispatch('page-changed');
        }
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->lastPage) {
            $this->currentPage++;
            $this->loadArticles();
            $this->dispatch('page-changed');
        }
    }

    // ✅ NEW: Handle Newsletter Subscription with WhatsApp Alert
    public function subscribeNewsletter()
    {
        $this->validate([
            'newsletterEmail' => 'required|email|max:255',
        ]);

        try {
            // ✅ WASNDER API CONFIGURATION
            $apiUrl     = config('services.wasender.api_url');
            $token      = config('services.wasender.bearer_token');
            $adminPhone = config('services.wasender.admin_phone');

            if (!empty($apiUrl) && !empty($token) && !empty($adminPhone)) {
                // ✅ FORMAT MESSAGE FOR WHATSAPP
                $whatsappMessage = "📧 *New Blog Newsletter Subscription*\n\n"
                    . "👤 *Email:* {$this->newsletterEmail}\n"
                    . "📄 *Source:* Blog Page\n"
                    . "📅 *Date:* " . now()->format('M d, Y h:i A');

                // ✅ SEND REQUEST USING LARAVEL HTTP CLIENT
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ])->post($apiUrl, [
                    'to'   => $adminPhone,
                    'text' => $whatsappMessage
                ]);

                if ($response->successful()) {
                    Log::info('Blog Newsletter WhatsApp Alert Sent:', ['email' => $this->newsletterEmail]);
                } else {
                    Log::warning('Blog Newsletter WhatsApp Alert Failed:', [
                        'status' => $response->status(),
                        'body'   => $response->body()
                    ]);
                }
            }

            // Show Success UI
            $this->showSubSuccess = true;
            $this->newsletterEmail = '';
            
            // Reset success message after 5 seconds (optional JS dispatch)
            $this->dispatch('reset-sub-success', delay: 5000);

        } catch (\Exception $e) {
            Log::error('Blog Newsletter Subscribe Error: ' . $e->getMessage());
            $this->showSubSuccess = true; // Still show success to user
            $this->newsletterEmail = '';
        }
    }
};
?>

<div class="blog-section-wrapper">
    <!-- Blog Section -->
    <section class="article-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        Latest Articles
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        Art & Inspiration
                    </h2>
                    <p class="text-gray-600 mt-2 max-w-2xl mx-auto" style="color: #6b3b4f;">
                        Explore stories, insights, and perspectives from the world of art and creativity.
                    </p>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <!-- Articles Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @forelse ($articles as $index => $article)
                        @php
                            $delays = ['200ms', '400ms', '600ms', '200ms', '400ms', '600ms'];
                            $delay = $delays[$index % 6];
                        @endphp
                        <div class="group" 
                             wire:key="article-{{ $article['id'] ?? $index }}"
                             style="animation: fadeInUp 0.6s ease-out {{ $delay }} both;">
                            <div class="article-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden h-full flex flex-col">
                                <!-- Article Image -->
                                <div class="relative overflow-hidden">
                                    <a href="/article-details/{{ $article['slug'] }}" class="block">
                                        <img 
                                            src="{{ asset('storage/' . $article['image']) }}" 
                                            alt="{{ $article['title'] }}"
                                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700"
                                            loading="lazy"
                                        >
                                    </a>
                                    
                                    <!-- Category Badge -->
                                    @if(isset($article['category']))
                                        <span class="absolute top-4 left-4 px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider"
                                              style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 4px 15px rgba(219, 32, 119, 0.3);">
                                            {{ $article['category'] }}
                                        </span>
                                    @endif

                                    <!-- Date Overlay -->
                                    <div class="absolute bottom-4 left-4 flex items-center gap-2 px-3 py-1.5 rounded-lg"
                                         style="background: rgba(26, 10, 15, 0.8); backdrop-filter: blur(8px);">
                                        <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-white text-xs font-medium">
                                            {{ \Carbon\Carbon::parse($article['published_at'])->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Article Content -->
                                <div class="article-content p-3 flex-1 flex flex-col">
                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-xs mb-3" style="color: #6b3b4f;">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $article['author'] ?? 'Latocross Artelier' }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            {{ $article['comments_count'] ?? 0 }} Comments
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h6 class="text-lg font-bold mb-2 line-clamp-2" style="color: #1a0a0f;">
                                        <a href="/article-details/{{ $article['slug'] }}" class="hover:underline">
                                            {{ $article['title'] }}
                                        </a>
                                    </h6>

                                    <!-- Excerpt -->
                                    <p class="text-sm line-clamp-2 flex-1" style="color: #6b3b4f;">
                                        {{ $article['excerpt'] ?? Str::limit(strip_tags($article['content'] ?? ''), 120) }}
                                    </p>

                                    <!-- Read More Button -->
                                    <a href="/article-details/{{ $article['slug'] }}" 
                                       class="group inline-flex items-center gap-2 mt-4 font-medium transition-all duration-300 hover:gap-3 text-sm"
                                       style="color: #DB2077;">
                                        <span>Read Article</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                                <svg class="w-20 h-20 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/>
                                </svg>
                                <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No Articles Yet</h4>
                                <p class="text-sm" style="color: #6b3b4f;">Check back soon for new content.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($lastPage > 1)
                    <div class="mt-12 flex flex-wrap items-center justify-center gap-4">
                        <!-- Previous Button -->
                        <button wire:click="prevPage" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium transition-all duration-300 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                style="{{ $currentPage == 1 
                                    ? 'background: #fce4ec; color: #6b3b4f;' 
                                    : 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;' }}"
                                {{ $currentPage == 1 ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </button>

                        <!-- Page Numbers -->
                        <div class="flex gap-1.5 flex-wrap justify-center">
                            @for ($i = 1; $i <= $lastPage; $i++)
                                <button wire:click="goToPage({{ $i }})"
                                        class="w-10 h-10 rounded-xl font-medium transition-all duration-300 hover:shadow-lg"
                                        style="{{ $currentPage == $i 
                                            ? 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 4px 15px rgba(219, 32, 119, 0.3);' 
                                            : 'background: #faf0f5; color: #6b3b4f;' }}">
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                </button>
                            @endfor
                        </div>

                        <!-- Next Button -->
                        <button wire:click="nextPage" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium transition-all duration-300 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                style="{{ $currentPage == $lastPage 
                                    ? 'background: #fce4ec; color: #6b3b4f;' 
                                    : 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;' }}"
                                {{ $currentPage == $lastPage ? 'disabled' : '' }}>
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Page Info -->
                    <div class="text-center mt-4 text-sm" style="color: #6b3b4f;">
                        Page <span class="font-bold" style="color: #DB2077;">{{ $currentPage }}</span> 
                        of <span class="font-bold" style="color: #DB2077;">{{ $lastPage }}</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Newsletter CTA Section -->
    <section class="newsletter-cta py-12" style="background: linear-gradient(135deg, #1a0a0f 0%, #2d1520 50%, #1a0a0f 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="mb-4">
                    <svg class="w-12 h-12 mx-auto" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/>
                    </svg>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-3" style="font-family: 'Georgia', serif;">
                    Never Miss an Article
                </h3>
                <p class="text-sm mb-6" style="color: #cdb4c8;">
                    Subscribe to our newsletter and get the latest art stories delivered to your inbox.
                </p>

                <!-- Success Message -->
                @if($showSubSuccess)
                    <div class="mb-4 p-3 rounded-xl flex items-start justify-center gap-3 max-w-md mx-auto" 
                         style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3);">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium" style="color: #86efac;">Subscribed!</p>
                            <p class="text-xs" style="color: #86efac;">Thank you for joining our community.</p>
                        </div>
                    </div>
                @endif

                <!-- Subscribe Form -->
                <form wire:submit.prevent="subscribeNewsletter" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" 
                           wire:model="newsletterEmail"
                           placeholder="Enter your email"
                           class="flex-1 px-4 py-3 rounded-xl border focus:outline-none focus:ring-2 text-sm"
                           style="border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white;"
                           wire:focus="border-color: #DB2077; ring-color: #DB2077;">
                    
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-lg hover:scale-105 disabled:opacity-70 disabled:cursor-not-allowed"
                            style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                        <span wire:loading.remove>Subscribe</span>
                        <svg wire:loading class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
                
                @error('newsletterEmail')
                    <p class="text-xs mt-2" style="color: #f87171;">{{ $message }}</p>
                @enderror

                <p class="text-xs mt-3" style="color: #6b3b4f;">
                    No spam. Unsubscribe anytime.
                </p>
            </div>
        </div>
    </section>

    <style>
        .blog-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card hover effects */
        .article-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .article-card:hover {
            transform: translateY(-6px);
        }

        /* Image zoom */
        .article-card img {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .article-card img {
            transform: scale(1.08);
        }

        /* Pagination buttons */
        button:active:not(:disabled) {
            transform: scale(0.95);
        }

        /* Focus styles */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Line clamp */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Newsletter input focus */
        .newsletter-cta input:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.15) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }
            
            .article-section {
                padding: 2rem 1rem;
            }
        }

        @media (max-width: 640px) {
            .article-card h6 {
                font-size: 1rem;
            }
            
            .pagination-numbers {
                gap: 0.5rem;
            }
            
            .pagination-numbers button {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 0.875rem;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }
            
            .newsletter-cta {
                display: none !important;
            }
            
            .pagination {
                display: none !important;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #fce4ec;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #DB2077;
            border-radius: 10px;
        }
    </style>
</div>