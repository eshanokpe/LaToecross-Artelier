<?php
use App\Models\Artwork;
use App\Models\Fashion;
use Livewire\Component;
use App\Models\Slider;

new class extends Component
{ 
    public $sliders;
    public $inspirationImages;

    public function mount()
    {
        $this->sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $this->inspirationImages = Artwork::query()
            ->whereNotNull('image')
            ->get(['id', 'title', 'image'])
            ->map(fn ($item) => ['id' => $item->id, 'title' => $item->title, 'image' => $item->image, 'type' => 'Artwork'])
            ->concat(
                Fashion::query()
                    ->whereNotNull('image')
                    ->get(['id', 'title', 'image'])
                    ->map(fn ($item) => ['id' => $item->id, 'title' => $item->title, 'image' => $item->image, 'type' => 'Fashion'])
            )
            ->shuffle()
            ->values();
    }
}; 
?>

<div class="slider-section-wrapper">
    <!-- Home1 Banner Section Start -->
    <div class="home1-banner-section mb-20 relative overflow-hidden">
        <div class="swiper home1-banner-slider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="banner-bg min-h-[600px] md:min-h-[700px] bg-cover bg-center" 
                             style="background-image: linear-gradient(135deg, rgba(26, 10, 15, 0.7) 0%, rgba(26, 10, 15, 0.7) 100%), url({{ asset('storage/' . $slider->image) }});">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="banner-wrapper absolute inset-0 flex items-center">
    <div class="container mx-auto px-4">
        <div class="row items-center">
            <div class="col-xxl-6 col-lg-6">
                @if ($sliders->isNotEmpty())
                    @php $first = $sliders->first(); @endphp
                    <div class="banner-content text-white">
                        <span class="inline-block text-sm sm:text-sm md:text-base font-semibold uppercase tracking-wider mb-4 px-4 py-1.0 rounded-full" 
                              style="background: rgba(219, 32, 119, 0.3); border: 1px solid rgba(219, 32, 119, 0.5);">
                            Welcome to Latocross Artelier
                        </span>
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4" style="font-family: 'Georgia', serif;">
                            {{ $first->title }}
                        </h2>
                        <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-xl">
                            {{ $first->description }}
                        </p>
                        @if ($first->button_text)
                            <a href="{{ $first->button_url }}" 
                                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105"
                                style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                <span>{{ $first->button_text }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-xxl-6 col-lg-6 order-first order-lg-2">
                @if ($inspirationImages->isNotEmpty())
                    <div class="swiper home1-inspiration-slider w-full max-w-md h-24 sm:h-28 mb-5 rounded-xl overflow-hidden border-2 border-white/60 shadow-xl ml-auto">
                        <div class="swiper-wrapper">
                            @foreach ($inspirationImages as $inspiration)
                                <div class="swiper-slide">
                                    <a href="{{ $inspiration['type'] === 'Artwork'
                                        ? route('artwork.show', \Vinkla\Hashids\Facades\Hashids::encode($inspiration['id']))
                                        : route('fashion.show', \Vinkla\Hashids\Facades\Hashids::encode($inspiration['id'])) }}"
                                    aria-label="View {{ strtolower($inspiration['type']) }}: {{ $inspiration['title'] }}"
                                    class="block w-full h-full">
                                        <img src="{{ asset('storage/' . $inspiration['image']) }}"
                                            alt="{{ $inspiration['type'] }}: {{ $inspiration['title'] }}"
                                            class="w-full h-full object-cover rounded-lg transition-transform duration-300 hover:scale-110"
                                            loading="lazy">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

        <div class="pagination-area absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10">
            <div class="swiper-pagination1 flex gap-2"></div>
        </div>
    </div>
    <!-- Home1 Banner Section End -->

    <style>
        .swiper-pagination1 .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0.7;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .swiper-pagination1 .swiper-pagination-bullet-active {
            background: #DB2077;
            opacity: 1;
            transform: scale(1.2);
            box-shadow: 0 0 20px rgba(219, 32, 119, 0.4);
        }
    </style>

    @script
    <script>
        new Swiper('.home1-inspiration-slider', {
            slidesPerView: 2,
            spaceBetween: 8,
            speed: 900,
            loop: {{ $inspirationImages->count() > 1 ? 'true' : 'false' }},
            autoplay: {
                delay: 2200,
                disableOnInteraction: false,
            },
            breakpoints: {
                480: {
                    slidesPerView: 3,
                },
            },
        });
    </script>
    @endscript
</div>