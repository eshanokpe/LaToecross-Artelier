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

        // Get all artworks for the category (removed take(8) limit)
        $this->artworks = $query->get();
        
        // Dispatch browser event to reinitialize Swiper
        $this->dispatch('artworks-updated');
    }

    public function filterByCategory($category): void
    {
        $this->selectedCategory = $category;
        $this->loadArtworks();
    }
};
?>

<div>
    <div class="home1-general-art-slider-section mb-10">
        <div class="container">
            <div class="row mb-10 align-items-center justify-content-between flex-wrap gap-3 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="col-lg-8 col-md-9">
                    <div class="section-title">
                        <h3>General Artwork</h3>
                        <p>Explore a curated collection of original artworks and fashion pieces, handpicked for the discerning collector.</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 d-flex justify-content-md-end">
                    <a href="{{ route('artworks.index') }}" class="view-all-btn">View All</a>
                </div>
            </div>

            {{-- Category Filter Tabs --}}
            <div class="row mb-4 wow animate fadeInUp" data-wow-delay="100ms" data-wow-duration="1500ms">
                <div class="col-12">
                    <div class="category-filter-tabs">
                        <ul class="nav nav-pills justify-content-center gap-2 flex-wrap">
                            @foreach ($categories as $key => $label)
                                <li class="nav-item">
                                    <button 
                                        wire:click="filterByCategory('{{ $key }}')"
                                        class="nav-link {{ $selectedCategory === $key ? 'active' : '' }}"
                                        type="button"
                                        wire:loading.attr="disabled">
                                        {{ $label }}
                                        <span wire:loading wire:target="filterByCategory('{{ $key }}')">
                                            <span class="spinner-border spinner-border-sm ms-1" role="status"></span>
                                        </span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="general-art-slider-wrap wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper home1-generat-art-slider" wire:key="artwork-slider-{{ $selectedCategory }}">
                            <div class="swiper-wrapper">
                                @forelse ($artworks as $artwork)
                                    <div class="swiper-slide" wire:key="artwork-{{ $artwork->id }}">
                                        <div class="auction-card general-art">
                                            <div class="auction-card-img-wrap">
                                                <a href="{{ route('artwork.show', $artwork) }}" class="card-img">
                                                    <img
                                                        src="{{ $artwork->image ? asset('storage/' . $artwork->image) : asset('assets/img/home1/general-art-img1.jpg') }}"
                                                        alt="{{ $artwork->title }}"
                                                        style="width: 100%; height: 200px; object-fit: cover;">
                                                </a>

                                                @unless ($artwork->is_for_sale)
                                                    <div class="batch">
                                                        <span class="sold-out">Sold Out</span>
                                                    </div>
                                                @endunless

                                                <a href="#" class="wishlist" wire:click.prevent="toggleWishlist({{ $artwork->id }})">
                                                    <svg width="16" height="15" viewBox="0 0 16 15" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.00013 3.32629L7.32792 2.63535C5.75006 1.01348 2.85685 1.57317 1.81244 3.61222C1.32211 4.57128 1.21149 5.95597 2.10683 7.72315C2.96935 9.42471 4.76378 11.4628 8.00013 13.6828C11.2365 11.4628 13.03 9.42471 13.8934 7.72315C14.7888 5.95503 14.6791 4.57128 14.1878 3.61222C13.1434 1.57317 10.2502 1.01254 8.67234 2.63441L8.00013 3.32629ZM8.00013 14.8125C-6.375 5.31378 3.57406 -2.09995 7.83512 1.8216C7.89138 1.87317 7.94669 1.9266 8.00013 1.98192C8.05303 1.92665 8.10807 1.87349 8.16513 1.82254C12.4253 -2.10182 22.3753 5.31284 8.00013 14.8125Z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="auction-card-content">
                                                <h6>
                                                    <a href="{{ route('artwork.show', $artwork) }}">{{ $artwork->title }}</a>
                                                </h6>
                                                <ul>
                                                    <li>
                                                        <span>Category : </span>
                                                        {{ $categories[$artwork->style] ?? $artwork->style }}
                                                    </li>
                                                    <li>
                                                        <span>Price : </span>
                                                        @if ($artwork->is_for_sale && $artwork->price)
                                                            ₦{{ number_format($artwork->price, 2) }}
                                                        @else
                                                            Not for sale
                                                        @endif
                                                    </li>
                                                </ul>
                                                <a href="{{ route('artwork.show', $artwork) }}" class="bid-btn {{ !$artwork->is_for_sale ? 'disabled' : '' }}">
                                                    <span>Read more</span>
                                                    <strong></strong>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="text-center py-5">
                                            <p class="text-muted">No artworks available in this category yet.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-btn-grp">
                    <div class="slider-btn generat-art-slider-prev">
                        <svg width="10" height="16" viewBox="0 0 10 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.735295 8.27932L10 16L4.10428 8.27932L10 0.558823L0.735295 8.27932Z"/>
                        </svg>
                    </div>
                    <div class="slider-btn generat-art-slider-next">
                        <svg width="10" height="16" viewBox="0 0 10 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.26471 7.72068L0 0L5.89572 7.72068L0 15.4412L9.26471 7.72068Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        let swiperInstance = null;

        function initSwiper() {
            // Destroy existing instance if it exists
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
            }

            // Small delay to ensure DOM is updated
            setTimeout(() => {
                swiperInstance = new Swiper(".home1-generat-art-slider", {
                    slidesPerView: 1,
                    speed: 1500,
                    spaceBetween: 24,
                    loop: false,
                    navigation: {
                        nextEl: ".generat-art-slider-next",
                        prevEl: ".generat-art-slider-prev",
                    },
                    breakpoints: {
                        280: {
                            slidesPerView: 1,
                        },
                        386: {
                            slidesPerView: 1,
                        },
                        576: {
                            slidesPerView: 2,
                            spaceBetween: 15,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 15,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 24,
                        },
                        1400: {
                            slidesPerView: 4,
                        },
                    },
                });
            }, 100);
        }

        // Initialize on page load
        initSwiper();

        // Reinitialize when artworks are updated
        $wire.on('artworks-updated', () => {
            initSwiper();
        });
    </script>
    @endscript
</div>

<!-- Same styling everywhere -->
<style>
.category-filter-tabs .nav-pills {
    flex-wrap: wrap;
}

.category-filter-tabs .nav-link {
    padding: 10px 20px;
    border-radius: 25px;
    background-color: #f8f9fa;
    color: #333;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    font-weight: 500;
    cursor: pointer;
}

.category-filter-tabs .nav-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.category-filter-tabs .nav-link.active {
    background-color: #DB2077;
    color: white;
    border-color: #DB2077;
}

/* Optional: Loading state */
.category-filter-tabs .nav-link[wire\:loading] {
    opacity: 0.6;
    pointer-events: none;
}
</style>