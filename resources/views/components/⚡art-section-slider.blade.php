<?php

use App\Models\Artwork;
use Livewire\Component;
use Livewire\Attributes\Url;

new class extends Component
{
    public $artworks;
    
    #[Url(as: 'category')]
    public $selectedCategory = 'all';

    public $categories = [
        'all' => 'All Artworks',
        'abstract' => 'Abstract Painting',
        'landscape' => 'Landscape Painting',
        'mixed_media' => 'Mixed Media Painting',
        'figure' => 'Figure Painting',
        'miniature' => 'Miniature',
    ];

    public function mount(): void
    {
        $this->loadArtworks();
    }

    public function loadArtworks(): void
    {
        $query = Artwork::query()->latest();

        if ($this->selectedCategory !== 'all') {
            $query->where('style', $this->selectedCategory);
        }

        $this->artworks = $query->get();
        $this->dispatch('artworks-updated');
    }

    public function filterByCategory($category): void
    {
        $this->selectedCategory = $category;
        $this->loadArtworks();
    }
};
?>

<div class="art-section-wrapper">
    <!-- Home1 General Art Slider Section -->
    <div class="home1-general-art-slider-section py-16 md:py-20" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-12">
                    <div class="section-title">
                        <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                            Featured Collection
                        </span>
                        <h3 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                            General Artwork
                        </h3>
                        <p class="text-gray-600 mt-2 max-w-xl" style="color: #6b3b4f;">
                            Explore a curated collection of original artworks and fashion pieces, handpicked for the discerning collector.
                        </p>
                    </div>
                    <a href="{{ route('artworks.index') }}" 
                       class="group inline-flex items-center gap-2 px-6 py-3 rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:scale-105"
                       style="color: #DB2077; background: #fce4ec;">
                        <span>View All</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Category Filter Tabs -->
                <div class="category-filter-tabs mb-10 overflow-x-auto">
                    <ul class="flex gap-2 flex-nowrap md:flex-wrap justify-center md:justify-start">
                        @foreach ($categories as $key => $label)
                            <li class="flex-shrink-0">
                                <button 
                                    wire:click="filterByCategory('{{ $key }}')"
                                    class="nav-link px-5 py-2.5 rounded-full font-medium transition-all duration-300 whitespace-nowrap text-sm"
                                    style="{{ $selectedCategory === $key 
                                        ? 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 4px 15px rgba(219, 32, 119, 0.3); transform: scale(1.02);' 
                                        : 'background: #faf0f5; color: #6b3b4f; border: 2px solid transparent;' }}"
                                    type="button"
                                    wire:loading.attr="disabled">
                                    {{ $label }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Artwork Slider -->
                <div class="general-art-slider-wrap relative">
                    <div class="swiper home1-generat-art-slider" wire:key="artwork-slider-{{ $selectedCategory }}">
                        <div class="swiper-wrapper">
                            @forelse ($artworks as $artwork)
                                <div class="swiper-slide" wire:key="artwork-{{ $artwork->id }}">
                                    <div class="auction-card general-art bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group h-full flex flex-col">
                                        <!-- Image Container -->
                                        <div class="auction-card-img-wrap relative overflow-hidden">
                                            <a href="{{ route('artwork.show', $artwork) }}" class="card-img block">
                                                <img
                                                    src="{{ $artwork->image ? asset('storage/' . $artwork->image) : asset('assets/img/home1/general-art-img1.jpg') }}"
                                                    alt="{{ $artwork->title }}"
                                                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700"
                                                    loading="lazy">
                                            </a>

                                            <!-- Status Badges -->
                                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                                @if($artwork->is_featured)
                                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                          style="background: #fce4ec; color: #DB2077; box-shadow: 0 2px 8px rgba(219, 32, 119, 0.2);">
                                                        ★ Featured
                                                    </span>
                                                @endif
                                                @unless ($artwork->is_for_sale)
                                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider" 
                                                          style="background: #1a0a0f; color: white; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">
                                                        Sold Out
                                                    </span>
                                                @endunless
                                                @if($artwork->is_for_sale)
                                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                          style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 2px 8px rgba(219, 32, 119, 0.2);">
                                                        For Sale
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Wishlist Button -->
                                            <button class="wishlist absolute top-3 right-3 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" 
                                                    style="background: rgba(255, 255, 255, 0.95); color: #DB2077; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);"
                                                    wire:click.prevent="toggleWishlist({{ $artwork->id }})">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            </button>

                                            <!-- Quick View Overlay -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <span class="px-4 py-2 rounded-full text-xs font-medium text-white bg-white/20 backdrop-blur-sm">
                                                    Quick View
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Content Container -->
                                        <div class="auction-card-content p-4 flex-1 flex flex-col">
                                            <h6 class="text-base font-bold line-clamp-1 mb-2" style="color: #1a0a0f;">
                                                <a href="{{ route('artwork.show', $artwork) }}" class="hover:text-DB2077 transition-colors">
                                                    {{ $artwork->title }}
                                                </a>
                                            </h6>
                                            
                                            <ul class="space-y-1.5 text-sm flex-1">
                                                <li class="flex justify-between items-center">
                                                    <span style="color: #6b3b4f;">Category</span>
                                                    <span style="color: #1a0a0f; font-weight: 500;">
                                                        {{ $categories[$artwork->style] ?? $artwork->style }}
                                                    </span>
                                                </li>
                                                @if($artwork->medium)
                                                    <li class="flex justify-between items-center">
                                                        <span style="color: #6b3b4f;">Medium</span>
                                                        <span style="color: #1a0a0f; font-weight: 500; font-size: 0.75rem;" class="truncate max-w-[100px]">
                                                            {{ $artwork->medium }}
                                                        </span>
                                                    </li>
                                                @endif
                                                <li class="flex justify-between items-center pt-1 border-t" style="border-color: #fce4ec;">
                                                    <span style="color: #6b3b4f;">Price</span>
                                                    <span style="color: #DB2077; font-weight: 700; font-size: 1.1rem;">
                                                        @if ($artwork->is_for_sale && $artwork->price)
                                                            ₦{{ number_format($artwork->price, 2) }}
                                                        @else
                                                            <span style="color: #6b3b4f; font-weight: 400;">N/A</span>
                                                        @endif
                                                    </span>
                                                </li>
                                            </ul>

                                            <a href="{{ route('artwork.show', $artwork) }}" 
                                               class="bid-btn block w-full text-center py-2.5 rounded-xl font-medium transition-all duration-300 hover:shadow-lg hover:scale-[1.02] mt-4 text-sm"
                                               style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                                <span>View Details</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                                        <svg class="w-20 h-20 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No Artworks Found</h4>
                                        <p class="text-sm" style="color: #6b3b4f;">No artworks available in this category yet.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Slider Navigation -->
                    <div class="slider-btn-grp flex justify-center gap-3 mt-8">
                        <button class="slider-btn generat-art-slider-prev w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" 
                                style="background: #fce4ec; color: #DB2077;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button class="slider-btn generat-art-slider-next w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Artwork Counter -->
                <div class="text-center mt-8 text-sm" style="color: #6b3b4f;">
                    Showing <span class="font-bold" style="color: #DB2077;">{{ $artworks->count() }}</span> 
                    artworks in 
                    <span class="font-bold" style="color: #DB2077;">
                        {{ $selectedCategory === 'all' ? 'All Categories' : ($categories[$selectedCategory] ?? 'Selected Category') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        let swiperInstance = null;

        function initSwiper() {
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
            }

            setTimeout(() => {
                swiperInstance = new Swiper(".home1-generat-art-slider", {
                    slidesPerView: 1,
                    speed: 800,
                    spaceBetween: 24,
                    loop: false,
                    navigation: {
                        nextEl: ".generat-art-slider-next",
                        prevEl: ".generat-art-slider-prev",
                    },
                    breakpoints: {
                        320: { slidesPerView: 1, spaceBetween: 15 },
                        480: { slidesPerView: 1, spaceBetween: 15 },
                        640: { slidesPerView: 2, spaceBetween: 15 },
                        768: { slidesPerView: 2, spaceBetween: 20 },
                        1024: { slidesPerView: 3, spaceBetween: 24 },
                        1280: { slidesPerView: 4, spaceBetween: 24 },
                        1536: { slidesPerView: 4, spaceBetween: 24 },
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

        document.addEventListener('DOMContentLoaded', initSwiper);

        $wire.on('artworks-updated', () => {
            initSwiper();
        });
    </script> 
    @endscript

    <style>
        .art-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1280px;
        }

        /* Category Filter Tabs */
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

        /* Card hover effects */
        .auction-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .auction-card:hover {
            transform: translateY(-4px);
        }

        /* Image zoom */
        .card-img img {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .card-img img {
            transform: scale(1.08);
        }

        /* Wishlist button */
        .wishlist {
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        .wishlist:hover {
            opacity: 1;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(219, 32, 119, 0.2);
        }

        /* Slider buttons */
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

        .batch span {
            animation: slideDown 0.5s ease-out;
        }

        .text-center svg {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Quick View Overlay */
        .quick-view-overlay {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
        }

        @media print {
            .slider-btn-grp, .category-filter-tabs, .wishlist {
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

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Smooth transitions for price */
        .price-value {
            transition: all 0.3s ease;
        }
    </style>
</div>