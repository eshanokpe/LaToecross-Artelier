<?php
use Livewire\Component;
use App\Models\Slider;

new class extends Component
{
    public $sliders;

    public function mount()
    {
        $this->sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
};
?>

<div>
    <!-- Home1 Banner Section Start -->
    <div class="home1-banner-section mb-120">
        <div class="swiper home1-banner-slider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="banner-bg" style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.46) 0%, rgba(0, 0, 0, 0.46) 100%), url({{ asset('storage/' . $slider->image) }});"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="banner-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-7 col-lg-8">
                        @if ($sliders->isNotEmpty())
                            @php $first = $sliders->first(); @endphp
                            <div class="banner-content">
                                <h1>{{ $first->title }}</h1>
                                <p>{{ $first->description }}</p>
                                @if ($first->button_text)
                                    <a href="{{ $first->button_url }}" class="primary-btn1 btn-hover">
                                        <span>{{ $first->button_text }}</span>
                                        <strong></strong>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="pagination-area">
            <div class="swiper-pagination1"></div>
        </div>
    </div>
    <!-- Home1 Banner Section End -->
</div>