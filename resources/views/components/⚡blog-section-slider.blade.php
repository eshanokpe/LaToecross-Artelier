<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component
{
    public $articles;
    public $selectedCategory = 'all';
    public $categories = [];

    public function mount(): void
    {
        // Get unique categories from articles
        $this->categories = Article::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();
        
        // Add 'All' at the beginning
        array_unshift($this->categories, 'all');
        
        $this->loadArticles();
    }

    public function loadArticles(): void
    {
        $query = Article::where('is_published', true)
            ->orderBy('published_at', 'desc');

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        $this->articles = $query->take(8)->get();
        $this->dispatch('blog-updated');
    }

    public function filterByCategory($category): void
    {
        $this->selectedCategory = $category;
        $this->loadArticles();
    }

    public function getCategoryLabel($category)
    {
        if ($category === 'all') return 'All';
        return ucfirst($category);
    }
};
?>

<div>
    <div class="blog-slider-wrapper">
        <div class="home1-blog-slider-section py-16 md:py-20" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    <!-- Section Header -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
                        <div class="section-title">
                            <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                                Blog
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Latest Articles
                            </h3>
                            <p class="text-gray-600 mt-2 max-w-xl" style="color: #6b3b4f;">
                                Discover stories, insights, and perspectives from the world of art and creativity.
                            </p>
                        </div>
                        <a href="{{ route('blog') }}" 
                           class="group inline-flex items-center gap-2 px-6 py-2.5 rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:scale-105"
                           style="color: #DB2077; background: #fce4ec;">
                            <span>View All</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Category Filter Tabs -->
                    @if(count($categories) > 1)
                        <div class="category-filter-tabs mb-8 overflow-x-auto">
                            <ul class="flex gap-2 flex-nowrap md:flex-wrap justify-center md:justify-start">
                                @foreach ($categories as $category)
                                    <li class="flex-shrink-0">
                                        <button 
                                            wire:click="filterByCategory('{{ $category }}')"
                                            class="nav-link px-4 py-2.5 rounded-full font-medium transition-all duration-300 whitespace-nowrap text-sm"
                                            style="{{ $selectedCategory === $category 
                                                ? 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 4px 15px rgba(219, 32, 119, 0.3); transform: scale(1.02);' 
                                                : 'background: #faf0f5; color: #6b3b4f; border: 2px solid transparent;' }}"
                                            type="button"
                                            wire:loading.attr="disabled">
                                            {{ $this->getCategoryLabel($category) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Blog Slider -->
                    <div class="blog-slider-wrap relative">
                        <div class="swiper home1-blog-slider" wire:key="blog-slider-{{ $selectedCategory }}">
                            <div class="swiper-wrapper">
                                @forelse ($articles as $article)
                                    <div class="swiper-slide" wire:key="article-{{ $article->id }}">
                                        <div class="blog-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group h-full flex flex-col">
                                            <!-- Image Container -->
                                            <div class="blog-card-img-wrap relative overflow-hidden">
                                                <a href="{{ route('article.show', $article->slug) }}" class="card-img block">
                                                    <img
                                                        src="{{ $article->image ? asset('storage/' . $article->image) : asset('assets/img/placeholder-blog.jpg') }}"
                                                        alt="{{ $article->title }}"
                                                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700"
                                                        loading="lazy">
                                                </a>

                                                <!-- Category Badge -->
                                                @if($article->category)
                                                    <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                          style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 2px 8px rgba(219, 32, 119, 0.2);">
                                                        {{ $article->category }}
                                                    </span>
                                                @endif

                                                <!-- Date Badge -->
                                                <span class="absolute bottom-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                      style="background: rgba(26, 10, 15, 0.8); color: white; backdrop-filter: blur(4px);">
                                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}
                                                </span>
                                            </div>

                                            <!-- Content Container -->
                                            <div class="blog-card-content p-4 flex-1 flex flex-col">
                                                <div class="flex items-center gap-2 text-xs mb-2" style="color: #6b3b4f;">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                        {{ $article->author ?? 'Latocross Artelier' }}
                                                    </span>
                                                    <span>•</span>
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                        </svg>
                                                        {{ $article->comments_count ?? 0 }}
                                                    </span>
                                                </div>

                                                <h6 class="text-base font-bold line-clamp-2 mb-2" style="color: #1a0a0f;">
                                                    <a href="{{ route('article.show', $article->slug) }}" class="hover:underline">
                                                        {{ $article->title }}
                                                    </a>
                                                </h6>
                                                
                                                <p class="text-sm line-clamp-2 flex-1" style="color: #6b3b4f;">
                                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content ?? ''), 100) }}
                                                </p>

                                                <a href="{{ route('article.show', $article->slug) }}" 
                                                   class="blog-btn inline-flex items-center gap-2 mt-3 text-sm font-medium transition-all duration-300 hover:gap-3"
                                                   style="color: #DB2077;">
                                                    <span>Read More</span>
                                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                                            <svg class="w-20 h-20 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"/>
                                            </svg>
                                            <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No Articles Found</h4>
                                            <p class="text-sm" style="color: #6b3b4f;">No articles available in this category yet.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Slider Navigation -->
                        <div class="slider-btn-grp flex justify-center gap-3 mt-8">
                            <button class="slider-btn blog-slider-prev w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" 
                                    style="background: #fce4ec; color: #DB2077;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="slider-btn blog-slider-next w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                    style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Blog Counter -->
                    <div class="text-center mt-8 text-sm" style="color: #6b3b4f;">
                        Showing <span class="font-bold" style="color: #DB2077;">{{ $articles->count() }}</span> 
                        articles in 
                        <span class="font-bold" style="color: #DB2077;">
                            {{ $selectedCategory === 'all' ? 'All Categories' : ucfirst($selectedCategory) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        let blogSwiperInstance = null;

        function initBlogSwiper() {
            if (blogSwiperInstance) {
                blogSwiperInstance.destroy(true, true);
            }

            setTimeout(() => {
                blogSwiperInstance = new Swiper(".home1-blog-slider", {
                    slidesPerView: 1,
                    speed: 800,
                    spaceBetween: 24,
                    loop: false,
                    navigation: {
                        nextEl: ".blog-slider-next",
                        prevEl: ".blog-slider-prev",
                    },
                    breakpoints: {
                        320: { slidesPerView: 1, spaceBetween: 15 },
                        480: { slidesPerView: 1, spaceBetween: 15 },
                        640: { slidesPerView: 2, spaceBetween: 15 },
                        768: { slidesPerView: 2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 24 },
                        1280: { slidesPerView: 3, spaceBetween: 24 },
                        1536: { slidesPerView: 3, spaceBetween: 24 },
                    },
                    autoHeight: true,
                    effect: 'slide',
                    keyboard: {
                        enabled: true,
                        onlyInViewport: true,
                    },
                });
            }, 150);
        }

        document.addEventListener('DOMContentLoaded', initBlogSwiper);

        $wire.on('blog-updated', () => {
            initBlogSwiper();
        });
    </script>
    @endscript

    <style>
        .blog-slider-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }


        .category-filter-tabs .nav-link {
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            position: relative;
        }

        .category-filter-tabs .nav-link:hover:not(.active) {
            border-color: #DB2077;
            transform: translateY(-2px);
            background: #fce4ec;
        }

        .category-filter-tabs .nav-link:active:not(.active) {
            transform: scale(0.95);
        }

        .category-filter-tabs .nav-link.active {
            border-color: #DB2077;
        }

        .category-filter-tabs .nav-link[wire\:loading] {
            opacity: 0.6;
            pointer-events: none;
        }

        @media (max-width: 640px) {
            .category-filter-tabs ul {
                justify-content: flex-start;
                padding-bottom: 0.5rem;
            }
            
            .category-filter-tabs .nav-link {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
        }

        .category-filter-tabs {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .category-filter-tabs::-webkit-scrollbar {
            display: none;
        }

        .blog-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .blog-card:hover {
            transform: translateY(-4px);
        }

        .card-img img {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .card-img img {
            transform: scale(1.08);
        }

        .slider-btn {
            transition: all 0.3s ease;
            cursor: pointer;
            user-select: none;
        }

        .slider-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 20px rgba(219, 32, 119, 0.2);
        }

        .slider-btn:active {
            transform: scale(0.95);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .text-center svg {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media print {
            .slider-btn-grp, .category-filter-tabs {
                display: none !important;
            }
        }

        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }

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

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</div>