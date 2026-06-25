<?php

use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public ?string $aboutTitle = null;
    public ?string $aboutContent = null;
    public ?string $aboutImage = null;

    public function mount(): void
    {
        $this->aboutTitle   = Setting::get('about_title', 'Discover Our Essence');
        $this->aboutContent = Str::limit(
            strip_tags(Setting::get('about_content', 'At Artmart, we are passionate art enthusiasts dedicated to connecting artists and collectors through dynamic and exciting auctions.')),
            325
        );
        $this->aboutImage   = Setting::get('about_image');
    }
};
?>

<div>
    <!-- Home2 About Section Start -->
    <div class="home2-about-section mb-120">
        <div class="container">
            <div class="about-wrapper">
                <div class="row g-4">
                    <div class="col-xxl-5 col-lg-6">
                        <div class="about-img">
                            <img
                                src="{{ $aboutImage ? asset('storage/' . $aboutImage) : asset('assets/img/home2/home2-about-img.jpg') }}"
                                alt="{{ $aboutTitle }}">
                        </div>
                    </div>
                    <div class="col-xxl-7 col-lg-6">
                        <div class="about-content">
                            <h3>{{ $aboutTitle }}</h3>
                            <p>{{ $aboutContent }}</p>
                            <div class="feature-list-and-btn-area">
                                <ul>
                                    <li>
                                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.5L5 10.5L11 1.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Integrity
                                    </li>
                                    <li>
                                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.5L5 10.5L11 1.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Diversity
                                    </li>
                                    <li>
                                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.5L5 10.5L11 1.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Accessibility
                                    </li>
                                    <li>
                                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.5L5 10.5L11 1.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Support
                                    </li>
                                </ul>
                                <a href="{{ route('about') }}" class="learn-btn">
                                    <svg width="104" height="104" viewBox="0 0 104 104" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M59.0718 6.7112L60.4661 12.8837C61.7977 18.7789 68.5628 21.5811 73.673 18.3542L79.0235 14.9754C85.5566 10.8499 93.1501 18.4434 89.0246 24.9765L85.6458 30.327C82.4189 35.4372 85.2211 42.2023 91.1163 43.5339L97.2888 44.9282C104.826 46.6306 104.826 57.3694 97.2888 59.0718L91.1163 60.4661C85.2211 61.7977 82.4189 68.5628 85.6458 73.673L89.0246 79.0235C93.1501 85.5566 85.5566 93.1501 79.0235 89.0246L73.673 85.6458C68.5628 82.4189 61.7977 85.2211 60.4661 91.1163L59.0718 97.2888C57.3694 104.826 46.6306 104.826 44.9282 97.2888L43.5339 91.1163C42.2023 85.2211 35.4372 82.4189 30.327 85.6458L24.9765 89.0246C18.4434 93.1501 10.8499 85.5566 14.9754 79.0235L18.3542 73.673C21.5811 68.5628 18.7789 61.7977 12.8837 60.4661L6.71121 59.0718C-0.825571 57.3694 -0.825575 46.6306 6.7112 44.9282L12.8837 43.5339C18.7789 42.2023 21.5811 35.4372 18.3542 30.327L14.9754 24.9765C10.8499 18.4434 18.4434 10.8499 24.9765 14.9754L30.327 18.3542C35.4372 21.5811 42.2023 18.7789 43.5339 12.8837L44.9282 6.71121C46.6306 -0.825571 57.3694 -0.825575 59.0718 6.7112Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>
                                        Read <br>More
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="countdown-wrap">
                    <ul class="countdown-list">
                        <li class="single-countdown">
                            <div class="number">
                                <h3 class="counter">65</h3>
                                <strong>k</strong>
                            </div>
                            <span>Happy Clients</span>
                        </li>
                        <li class="single-countdown">
                            <div class="number">
                                <h3 class="counter">1.5</h3>
                                <strong>k</strong>
                            </div>
                            <span>Artworks &amp; Designs</span>
                        </li>
                        <li class="single-countdown">
                            <div class="number">
                                <h3 class="counter">350</h3>
                            </div>
                            <span>Artists &amp; Designers</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Home2 About Section End -->
</div>