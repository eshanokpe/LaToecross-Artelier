<?php

use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public ?string $aboutTitle = null;
    public ?string $aboutContent = null;
    public ?string $fullContent = null;
    public ?string $aboutImage = null;
    public ?string $aboutImage2 = null;
    public bool $showFullContent = false;
    public ?string $aboutTagline = null;
    public ?string $establishedYear = null;

    public function mount(): void
    {
        $this->aboutTitle       = Setting::get('about_title', 'Discover Our Essence');
        $this->aboutTagline     = Setting::get('about_tagline', 'Where Art Meets Passion');
        $this->establishedYear  = Setting::get('established_year', '2020');
        $this->fullContent      = Setting::get('about_content', '');

        // Strip tags only for the short preview, keep full content intact
        $this->aboutContent = Str::limit(strip_tags($this->fullContent), 350);

        $this->aboutImage       = Setting::get('about_image');
        $this->aboutImage2      = Setting::get('about_image_2');
    }

    public function toggleContent(): void
    {
        $this->showFullContent = !$this->showFullContent;
    }

    public function getImageUrl(?string $imagePath): string
    {
        return $imagePath ? asset('storage/' . $imagePath) : asset('assets/img/placeholder.jpg');
    }
};
?>

{{-- ✅ Single root element wrapping everything --}}
<div class="about-section-wrapper">

    <section class="about-section py-16 md:py-24" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        About Latocross Artelier
                    </span>
                    <h2 id="about-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold mt-4" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        {{ $aboutTitle }}
                    </h2>
                    <p class="text-lg mt-3 max-w-2xl mx-auto" style="color: #6b3b4f;">
                        {{ $aboutTagline }}
                    </p>
                    <div class="w-24 h-1 mx-auto mt-6 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Content Column -->
                    <div class="order-2 lg:order-1">
                        <div class="space-y-6">
                            <!-- Established Badge -->
                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full" style="background: #fce4ec;">
                                    <svg class="w-4 h-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium" style="color: #1a0a0f;">Est. {{ $establishedYear }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm font-medium" style="color: #1a0a0f;">4.9/5 Rating</span>
                                </div>
                            </div>

                            <!-- About Content -->
                            <div class="prose prose-lg max-w-none">
                                <div class="leading-relaxed space-y-4" style="color: #2d1b24;">
                                    @if ($showFullContent)
                                        <div class="transition-all duration-500 ease-in-out">
                                            {!! nl2br($fullContent) !!}
                                        </div>
                                    @else
                                        <div class="transition-all duration-500 ease-in-out">
                                            {{ $aboutContent }}
                                            @if (strlen(strip_tags($fullContent)) > 350)
                                                <span style="color: #DB2077;">...</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Read More/Less Button -->
                            @if (strlen(strip_tags($fullContent)) > 350)
                                <div class="flex items-center gap-4 pt-2">
                                    <button 
                                        wire:click="toggleContent" 
                                        class="group inline-flex items-center gap-2 font-semibold transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg px-4 py-2" 
                                        style="color: #DB2077; background: #fce4ec;"
                                        type="button"
                                        aria-expanded="{{ $showFullContent ? 'true' : 'false' }}"
                                    >
                                        <span>{{ $showFullContent ? 'Show Less' : 'Read More' }}</span>
                                        <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1 {{ $showFullContent ? 'rotate-180' : '' }}" 
                                             fill="none" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    @if ($showFullContent)
                                        <span class="text-sm animate-fade-in" style="color: #DB2077;">
                                            ✓ Full story displayed
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Key Highlights -->
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t" style="border-color: #f5d6e0;">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #fce4ec;">
                                        <svg class="w-4 h-4" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm" style="color: #2d1b24;">Curated Artworks</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #fce4ec;">
                                        <svg class="w-4 h-4" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm" style="color: #2d1b24;">Verified Artists</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #fce4ec;">
                                        <svg class="w-4 h-4" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm" style="color: #2d1b24;">Secure Transactions</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #fce4ec;">
                                        <svg class="w-4 h-4" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm" style="color: #2d1b24;">Global Delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Column -->
                    <div class="order-1 lg:order-2">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2 relative rounded-2xl overflow-hidden shadow-xl">
                                <img
                                    src="{{ $this->getImageUrl($aboutImage) }}"
                                    alt="{{ $aboutTitle }} - Main Image"
                                    class="w-full h-64 lg:h-80 object-cover hover:scale-105 transition-transform duration-700"
                                    loading="lazy"
                                >
                                <div class="absolute bottom-0 left-0 right-0 p-4" style="background: linear-gradient(180deg, transparent, rgba(219, 32, 119, 0.8));">
                                    <p class="text-white text-sm font-medium" style="font-family: 'Georgia', serif;">Discover African Art</p>
                                </div>
                            </div>

                            @if($aboutImage2)
                                <div class="col-span-2 md:col-span-1 relative rounded-xl overflow-hidden shadow-lg">
                                    <img
                                        src="{{ $this->getImageUrl($aboutImage2) }}"
                                        alt="{{ $aboutTitle }} - Secondary Image"
                                        class="w-full h-48 object-cover hover:scale-105 transition-transform duration-700"
                                        loading="lazy"
                                    >
                                </div>
                            @endif

                            <div class="hidden md:block col-span-1">
                                <div class="h-48 rounded-xl flex items-center justify-center p-6" style="background: linear-gradient(135deg, #fce4ec, #f5d6e0);">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold" style="color: #DB2077;">50+</div>
                                        <div class="text-sm" style="color: #6b3b4f;">Artists</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="py-8 text-white" style="background: linear-gradient(90deg, #1a0a0f, #DB2077, #ff6b9d);">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">50+</div>
                    <div class="text-sm mt-1" style="color: #ffc1dc;">Artists</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">200+</div>
                    <div class="text-sm mt-1" style="color: #ffc1dc;">Artworks</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">1000+</div>
                    <div class="text-sm mt-1" style="color: #ffc1dc;">Collectors</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">4.9★</div>
                    <div class="text-sm mt-1" style="color: #ffc1dc;">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .about-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1280px;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-500 {
            transition-duration: 500ms;
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-700 {
            transition-duration: 700ms;
        }

        @media (max-width: 768px) {
            .about-section { padding: 3rem 1rem; }
            .grid-cols-2 { gap: 0.75rem; }
            .text-3xl { font-size: 1.75rem; }
        }

        @media (max-width: 640px) {
            .grid-cols-2 { grid-template-columns: 1fr; }
            .stats-bar .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        }

        @media print {
            .stats-bar { display: none; }
            .group:hover .group-hover\:scale-105 { transform: none; }
        }

        button:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }

        .prose { max-width: none; }
        .prose p { margin-bottom: 1rem; line-height: 1.75; }
        .prose p:last-child { margin-bottom: 0; }

        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>

</div>
{{-- ✅ End of single root element --}}