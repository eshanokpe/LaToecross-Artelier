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
        $this->aboutTitle = Setting::get('about_title', 'Discover Our Essence');
        $this->aboutTagline = Setting::get('about_tagline', 'Where Art Meets Passion');
        $this->establishedYear = Setting::get('established_year', '2020');
        
        // Store full clean content with preserved formatting
        $this->fullContent = Setting::get('about_content', 'At Artmart, we are passionate art enthusiasts dedicated to connecting artists and collectors through dynamic and exciting auctions. Our platform brings together a curated selection of contemporary African art, showcasing the rich cultural heritage and creative innovation of the continent\'s most talented artists.');

        // Truncate content for initial view
        $this->aboutContent = Str::limit($this->fullContent, 350);

        $this->aboutImage = Setting::get('about_image');
        $this->aboutImage2 = Setting::get('about_image_2');
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

<div class="about-section-wrapper">
    <!-- About Section -->
    <section class="about-section py-16 md:py-24 bg-gradient-to-b from-white to-gray-50" aria-labelledby="about-heading">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 md:mb-16">
                    <span class="inline-block text-indigo-600 font-semibold text-sm uppercase tracking-wider bg-indigo-50 px-4 py-1.5 rounded-full">
                        About Us
                    </span>
                    <h2 id="about-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mt-4">
                        {{ $aboutTitle }}
                    </h2>
                    <p class="text-lg text-gray-600 mt-3 max-w-2xl mx-auto">
                        {{ $aboutTagline }}
                    </p>
                    <div class="w-24 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-6 rounded-full"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Content Column -->
                    <div class="order-2 lg:order-1">
                        <div class="space-y-6">
                            <!-- Established Badge -->
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-full">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Est. {{ $establishedYear }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">4.9/5 Rating</span>
                                </div>
                            </div>

                            <!-- About Content with Read More/Less -->
                            <div class="prose prose-lg max-w-none">
                                <div class="text-gray-700 leading-relaxed space-y-4">
                                    @if ($showFullContent)
                                        <div class="transition-all duration-500 ease-in-out">
                                            {!! nl2br(e($fullContent)) !!}
                                        </div>
                                    @else
                                        <div class="transition-all duration-500 ease-in-out">
                                            {!! nl2br(e($aboutContent)) !!}
                                            @if (strlen($fullContent) > 350)
                                                <span class="text-gray-400">...</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Read More/Less Button -->
                            @if (strlen($this->fullContent) > 350)
                                <div class="flex items-center gap-4 pt-2">
                                    <button 
                                        wire:click="toggleContent" 
                                        class="group inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg px-4 py-2 bg-indigo-50 hover:bg-indigo-100"
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
                                        <span class="text-sm text-gray-500 animate-fade-in">
                                            ✓ Full story displayed
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Key Highlights -->
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Curated Artworks</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Verified Artists</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Secure Transactions</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Global Delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Column -->
                    <div class="order-1 lg:order-2">
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Main Image -->
                            <div class="col-span-2 relative rounded-2xl overflow-hidden shadow-xl">
                                <img
                                    src="{{ $this->getImageUrl($aboutImage) }}"
                                    alt="{{ $aboutTitle }} - Main Image"
                                    class="w-full h-64 lg:h-80 object-cover hover:scale-105 transition-transform duration-700"
                                    loading="lazy"
                                >
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                    <p class="text-white text-sm font-medium">Discover African Art</p>
                                </div>
                            </div>

                            <!-- Secondary Images -->
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

                            <!-- Decorative Elements -->
                            <div class="hidden md:block col-span-1">
                                <div class="h-48 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center p-6">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-indigo-600">50+</div>
                                        <div class="text-sm text-gray-600">Artists</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional: Stats Bar -->
    <section class="stats-bar bg-indigo-900 text-white py-8" aria-label="Company statistics">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">50+</div>
                    <div class="text-sm text-indigo-300 mt-1">Artists</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">200+</div>
                    <div class="text-sm text-indigo-300 mt-1">Artworks</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">1000+</div>
                    <div class="text-sm text-indigo-300 mt-1">Collectors</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">4.9★</div>
                    <div class="text-sm text-indigo-300 mt-1">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Styling -->
    <style>
        .about-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1280px;
        }

        /* Smooth content transitions */
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

        /* Fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        /* Hover effects for images */
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

        /* Image hover overlay */
        .group:hover .group-hover\:opacity-75 {
            opacity: 0.75;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .about-section {
                padding: 3rem 1rem;
            }

            .grid-cols-2 {
                gap: 0.75rem;
            }

            .text-3xl {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .stats-bar .grid-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Print styles */
        @media print {
            .stats-bar {
                display: none;
            }

            .group:hover .group-hover\:scale-105 {
                transform: none;
            }
        }

        /* Focus styles for accessibility */
        .read-more-btn:focus-visible,
        button:focus-visible {
            outline: 2px solid #4F46E5;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Prose content styling */
        .prose {
            max-width: none;
        }

        .prose p {
            margin-bottom: 1rem;
            line-height: 1.75;
        }

        .prose p:last-child {
            margin-bottom: 0;
        }

        /* Button hover animation */
        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Stats bar gradient border */
        .stats-bar {
            position: relative;
            overflow: hidden;
        }

        .stats-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
    </style>
</div>