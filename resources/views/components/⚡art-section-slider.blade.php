<?php

use App\Models\Artwork;
use Livewire\Component;

new class extends Component
{
    public $artworks;

    public function mount(): void
    {
        $this->artworks = Artwork::query()
            ->latest()
            ->take(8)
            ->get();
    }
};
?>

<div>
    <div class="home1-general-art-slider-section mb-120">
        <div class="container">
            <div class="row mb-60 align-items-center justify-content-between flex-wrap gap-3 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="col-lg-8 col-md-9">
                    <div class="section-title">
                        <h3>General Artwork</h3>
                        <p>Explore a curated collection of original artworks and fashion pieces, handpicked for the discerning collector.</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 d-flex justify-content-md-end">
                    <a href="{{ route('artwork.index') }}" class="view-all-btn">View All</a>
                </div>
            </div>

            <div class="general-art-slider-wrap wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper home1-generat-art-slider">
                            <div class="swiper-wrapper">
                                @forelse ($artworks as $artwork)
                                    <div class="swiper-slide">
                                        <div class="auction-card general-art">
                                            <div class="auction-card-img-wrap">
                                                <a href="{{ route('artwork.show', $artwork) }}" class="card-img">
                                                    <img
                                                        src="{{ $artwork->image ? asset('storage/' . $artwork->image) : asset('assets/img/home1/general-art-img1.jpg') }}"
                                                        alt="{{ $artwork->title }}"
                                                        style="width: 100%; height: 280px; object-fit: cover;">
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
                                                        <span>Artist : </span>
                                                        {{ $artwork->artist }}
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
                                                <a href="{{ route('artwork.show', $artwork) }}" class="bid-btn btn-hover {{ !$artwork->is_for_sale ? 'disabled' : '' }}">
                                                    <span>Buy Now</span>
                                                    <strong></strong>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <p>No artworks available yet.</p>
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
</div>