<?php

use App\Models\Fashion;
use Livewire\Component;
use Livewire\Attributes\Url;

new class extends Component
{
    public $fashions;
    
    #[Url(as: 'category')]
    public $selectedCategory = 'all';

    public $categories = [
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

    public function mount(): void
    {
        $this->loadFashions();
    }

    public function loadFashions(): void
    {
        $query = Fashion::query()->latest();

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        $this->fashions = $query->get();
        $this->dispatch('fashions-updated');
    }

    public function filterByCategory($category): void
    {
        $this->selectedCategory = $category;
        $this->loadFashions();
    }
};
?>

<div>
    <div class="fashion-slider-wrapper">
        <div class="home1-fashion-slider-section py-16 md:py-20" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    <!-- Section Header -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
                        <div class="section-title">
                            <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                                Fashion Collection
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Featured Fashion
                            </h3>
                            <p class="text-gray-600 mt-2 max-w-xl" style="color: #6b3b4f;">
                                Explore our curated collection of unique fashion pieces, handcrafted by talented designers.
                            </p>
                        </div>
                        <a href="{{ route('fashions.index') }}" 
                           class="group inline-flex items-center gap-2 px-6 py-2.5 rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:scale-105"
                           style="color: #DB2077; background: #fce4ec;">
                            <span>View All</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Category Filter Tabs -->
                    <div class="category-filter-tabs mb-8 overflow-x-auto">
                        <ul class="flex gap-2 flex-nowrap md:flex-wrap justify-center md:justify-start">
                            @foreach ($categories as $key => $label)
                                <li class="flex-shrink-0">
                                    <button 
                                        wire:click="filterByCategory('{{ $key }}')"
                                        class="nav-link px-4 py-2.5 rounded-full font-medium transition-all duration-300 whitespace-nowrap text-sm"
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

                    <!-- Fashion Slider -->
                    <div class="fashion-slider-wrap relative">
                        <div class="swiper home1-fashion-slider" wire:key="fashion-slider-{{ $selectedCategory }}">
                            <div class="swiper-wrapper">
                                @forelse ($fashions as $fashion)
                                    <div class="swiper-slide" wire:key="fashion-{{ $fashion->id }}">
                                        <div class="fashion-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group h-full flex flex-col">
                                            <!-- Image Container -->
                                            <div class="fashion-card-img-wrap relative overflow-hidden">
                                                <a href="{{ route('fashion.show', $fashion->id) }}" class="card-img block">
                                                    <img
                                                        src="{{ $fashion->image ? asset('storage/' . $fashion->image) : asset('assets/img/placeholder-fashion.jpg') }}"
                                                        alt="{{ $fashion->title }}"
                                                        class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700"
                                                        loading="lazy">
                                                </a>

                                                <!-- Status Badges -->
                                                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                                    @if($fashion->is_featured)
                                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                              style="background: #fce4ec; color: #DB2077; box-shadow: 0 2px 8px rgba(219, 32, 119, 0.2);">
                                                            ★ Featured
                                                        </span>
                                                    @endif
                                                    @if($fashion->is_for_sale)
                                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                              style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 2px 8px rgba(219, 32, 119, 0.2);">
                                                            For Sale
                                                        </span>
                                                    @else
                                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider" 
                                                              style="background: #1a0a0f; color: white; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">
                                                            Sold Out
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Category Tag -->
                                                <span class="absolute bottom-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                      style="background: rgba(26, 10, 15, 0.8); color: white; backdrop-filter: blur(4px);">
                                                    {{ $categories[$fashion->category] ?? $fashion->category }}
                                                </span>

                                            </div>

                                            <!-- Content Container -->
                                            <div class="fashion-card-content p-4 flex-1 flex flex-col">
                                                <h6 class="text-base font-bold line-clamp-1 mb-1" style="color: #1a0a0f;">
                                                    <a href="{{ route('fashion.show', $fashion->id) }}" class="hover:underline">
                                                        {{ $fashion->title }}
                                                    </a>
                                                </h6>
                                                
                                                <ul class="space-y-1 text-sm flex-1">
                                                    <li class="flex justify-between">
                                                        <span style="color: #6b3b4f;">Designer</span>
                                                        <span style="color: #1a0a0f; font-weight: 500;">
                                                            {{ $fashion->designer ?? 'Unknown' }}
                                                        </span>
                                                    </li>
                                                    @if($fashion->material)
                                                        <li class="flex justify-between">
                                                            <span style="color: #6b3b4f;">Material</span>
                                                            <span style="color: #1a0a0f; font-weight: 500; font-size: 0.75rem;" class="truncate max-w-[100px]">
                                                                {{ $fashion->material }}
                                                            </span>
                                                        </li>
                                                    @endif
                                                    <li class="flex justify-between">
                                                        <span style="color: #6b3b4f;">Price</span>
                                                        <span style="color: #DB2077; font-weight: 700;">
                                                            @if ($fashion->is_for_sale && $fashion->price)
                                                                ₦{{ number_format($fashion->price, 2) }}
                                                            @else
                                                                <span style="color: #6b3b4f; font-weight: 400;">N/A</span>
                                                            @endif
                                                        </span>
                                                    </li>
                                                </ul>

                                                <a href="{{ route('fashion.show', $fashion->id) }}" 
                                                   class="fashion-btn block w-full text-center py-2.5 rounded-xl font-medium transition-all duration-300 hover:shadow-lg hover:scale-[1.02] mt-3 text-sm"
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
                                            <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No Fashion Items Found</h4>
                                            <p class="text-sm" style="color: #6b3b4f;">No fashion items available in this category yet.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Slider Navigation -->
                        <div class="slider-btn-grp flex justify-center gap-3 mt-8">
                            <button class="slider-btn fashion-slider-prev w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" 
                                    style="background: #fce4ec; color: #DB2077;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="slider-btn fashion-slider-next w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg"
                                    style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Fashion Counter -->
                    <div class="text-center mt-8 text-sm" style="color: #6b3b4f;">
                        Showing <span class="font-bold" style="color: #DB2077;">{{ $fashions->count() }}</span> 
                        fashion items in 
                        <span class="font-bold" style="color: #DB2077;">
                            {{ $selectedCategory === 'all' ? 'All Categories' : ($categories[$selectedCategory] ?? 'Selected Category') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        let fashionSwiperInstance = null;

        function initFashionSwiper() {
            if (fashionSwiperInstance) {
                fashionSwiperInstance.destroy(true, true);
            }

            setTimeout(() => {
                fashionSwiperInstance = new Swiper(".home1-fashion-slider", {
                    slidesPerView: 1,
                    speed: 800,
                    spaceBetween: 24,
                    loop: false,
                    navigation: {
                        nextEl: ".fashion-slider-next",
                        prevEl: ".fashion-slider-prev",
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

        document.addEventListener('DOMContentLoaded', initFashionSwiper);

        $wire.on('fashions-updated', () => {
            initFashionSwiper();
        });
    </script>
    @endscript

    <style>
        .fashion-slider-wrapper {
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

        .fashion-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fashion-card:hover {
            transform: translateY(-4px);
        }

        .card-img img {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .card-img img {
            transform: scale(1.08);
        }

        .wishlist {
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        .wishlist:hover {
            opacity: 1;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(219, 32, 119, 0.2);
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
    </style>
</div>