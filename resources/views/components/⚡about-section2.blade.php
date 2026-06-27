<?php

use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public ?string $aboutTitle = null;
    public ?string $aboutContent = null;
    public ?string $aboutImage = null;
    public ?string $aboutImage2 = null;

    public function mount(): void
    {
        $this->aboutTitle   = Setting::get('about_title', 'Discover Our Essence');
        $this->aboutContent = Str::limit(
            strip_tags(Setting::get('about_content', 'At Artmart, we are passionate art enthusiasts dedicated to connecting artists and collectors through dynamic and exciting auctions.')),
            325
        );
        $this->aboutImage   = Setting::get('about_image');
        $this->aboutImage2   = Setting::get('about_image_2');
    }
};
?>

<div>
    <!-- discover section  strats -->
        <div class="discover-section mb-120">
            <div class="container">
                <div class="row gy-4 ">
                    <div class="col-lg-6 wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="discover-content">
                            <h3 style=" font-size: 30px;" >{{ $aboutTitle }}</h3>
                            <p>{{ $aboutContent }}</p>
                           
                           
                        </div>
                    </div>
                    <div class="col-lg-6 wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="discover-section-image">
                            <div class="row g-2">
                                <div class="col-lg-6">
                                    <img
                                    src="{{ asset('storage/' . $aboutImage)  }}"
                                    alt="{{ $aboutTitle }}">
                                </div>
                                <div class="col-lg-6">
                                     <img
                                    src="{{ asset('storage/' . $aboutImage2)  }}"
                                    alt="{{ $aboutTitle }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- discover section  ends -->
</div>