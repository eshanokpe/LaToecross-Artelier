<?php

use App\Models\Setting;
use Livewire\Component;

new class extends Component
{
    public ?string $aboutTitle = null;
    public ?string $mission = null;
    public ?string $vision = null;
    public ?string $whatMakesSpecial = null;
    public ?string $whatMakesSpecialImage = null;
    public ?string $aboutDescription = null;
    public ?string $establishedYear = null;

    /**
     * Initialize component with settings data.
     */
    public function mount(): void
    {
        $this->loadSettings();
    }

    /**
     * Load all settings from the database.
     */
    private function loadSettings(): void
    {
        $this->aboutTitle = Setting::get('about_title', 'About Us');
        $this->vision = Setting::get('vision', 'To become Africa\'s leading platform for contemporary art discovery and appreciation.');
        $this->mission = Setting::get('mission', 'Connecting talented artists with art enthusiasts through an immersive digital experience.');
        $this->aboutDescription = Setting::get('about_description', 'We are passionate about showcasing the vibrant and diverse artistic talent across Nigeria and the African continent.');
        $this->whatMakesSpecial = Setting::get('what_makes_special');
        $this->whatMakesSpecialImage = Setting::get('what_makes_special_image');
        $this->establishedYear = Setting::get('established_year', '2020');
    }

    /**
     * Get the image URL with fallback to placeholder.
     */
    public function getImageUrl(): string
    {
        return $this->whatMakesSpecialImage 
            ? asset('storage/' . $this->whatMakesSpecialImage)
            : asset('assets/img/placeholder.jpg');
    }

    /**
     * Check if content exists for display.
     */
    public function hasContent(string $content): bool
    {
        return !empty($content) && $content !== 'Our vision statement will appear here once configured.';
    }
}; ?>

<div class="about-page">
    {{-- Hero Section --}}
    <section class="about-hero-section bg-gradient-to-r from-indigo-900 via-purple-900 to-indigo-800 text-white py-16 md:py-24 relative overflow-hidden" aria-labelledby="hero-heading">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-purple-500 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-block text-purple-300 font-semibold text-sm uppercase tracking-wider mb-4 border border-purple-400/30 px-4 py-1.5 rounded-full">
                    Since {{ $establishedYear }}
                </span>
                <h1 id="hero-heading" class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    {{ $aboutTitle }}
                </h1>
                <p class="text-lg md:text-xl text-purple-100 leading-relaxed max-w-2xl mx-auto">
                    {{ $aboutDescription }}
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="#vision-section" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm hover:bg-white/20 px-6 py-3 rounded-full transition-all duration-300 border border-white/20">
                        <span>Discover Our Story</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="stats-section py-12 bg-white border-b border-gray-100" aria-label="Company statistics">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600">50+</div>
                    <div class="text-sm text-gray-600 mt-1">Artists Featured</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600">200+</div>
                    <div class="text-sm text-gray-600 mt-1">Artworks</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600">1000+</div>
                    <div class="text-sm text-gray-600 mt-1">Happy Collectors</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600">4.9</div>
                    <div class="text-sm text-gray-600 mt-1">Rating ★</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission Section --}}
    <section id="vision-section" class="vision-mission-section py-16 md:py-20 bg-gray-50" aria-labelledby="vision-heading">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Our Foundation</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Driven by Purpose</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-4"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    {{-- Vision Card --}}
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 md:p-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:opacity-75 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <h3 id="vision-heading" class="text-2xl font-bold text-gray-900">Our Vision</h3>
                            </div>
                            <p class="text-gray-700 leading-relaxed text-lg">
                                {{ $vision }}
                            </p>
                            <div class="mt-6 flex items-center text-indigo-600 font-medium">
                                <span class="text-sm">Guiding our future</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Mission Card --}}
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 md:p-10 relative overflow-hidden">
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-100 to-pink-100 rounded-full translate-y-1/2 -translate-x-1/2 opacity-50 group-hover:opacity-75 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 id="mission-heading" class="text-2xl font-bold text-gray-900">Our Mission</h3>
                            </div>
                            <p class="text-gray-700 leading-relaxed text-lg">
                                {{ $mission }}
                            </p>
                            <div class="mt-6 flex items-center text-purple-600 font-medium">
                                <span class="text-sm">Our daily commitment</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- What Makes Us Special Section --}}
    <section class="special-section py-16 md:py-20 bg-white" aria-labelledby="special-heading">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">What Sets Us Apart</span>
                    <h2 id="special-heading" class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Our Unique Value</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-4"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    {{-- Content Column --}}
                    <div class="space-y-6">
                        <div class="prose prose-lg max-w-none">
                            <div class="text-gray-700 leading-relaxed space-y-4">
                                {!! $whatMakesSpecial ?: '<p class="text-gray-500 italic">Our unique qualities and advantages will appear here once configured.</p>' !!}
                            </div>
                        </div>

                        {{-- Feature Points --}}
                        <div class="grid sm:grid-cols-2 gap-4 pt-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Authentic African Art</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Curated Collections</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Direct Artist Support</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Global Community</span>
                            </div>
                        </div>
                    </div>

                    {{-- Image Column --}}
                    <div class="relative">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 to-purple-600/20 mix-blend-overlay"></div>
                            <img src="{{ $this->getImageUrl() }}"
                                 alt="{{ $aboutTitle ?: 'What Makes Us Special' }}"
                                 class="w-full h-auto object-cover"
                                 loading="lazy">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                                <p class="text-white text-sm font-medium">Celebrating African Artistic Excellence</p>
                            </div>
                        </div>
                        
                        {{-- Decorative Elements --}}
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-indigo-200 to-purple-200 rounded-full opacity-50 -z-10"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-tr from-purple-200 to-pink-200 rounded-full opacity-50 -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta-section py-16 bg-gradient-to-r from-indigo-900 to-purple-900 text-white" aria-label="Call to action">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Discover Amazing Art?</h2>
                <p class="text-lg text-purple-200 mb-8 max-w-2xl mx-auto">
                    Join our community of art lovers and collectors. Explore curated collections from Africa's most talented artists.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/artworks" class="inline-flex items-center gap-2 bg-white text-indigo-900 hover:bg-gray-100 px-8 py-3.5 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span>Browse Artworks</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="/contact" class="inline-flex items-center gap-2 border border-white/30 hover:border-white/60 px-8 py-3.5 rounded-full transition-all duration-300">
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Professional Styling Enhancements */
.about-page {
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

.container {
    max-width: 1280px;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Card hover effects */
.group:hover .group-hover\:shadow-2xl {
    transform: translateY(-4px);
}

/* Gradient text utilities */
.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Prose styling */
.prose h1, .prose h2, .prose h3, .prose h4 {
    color: #1a1a1a;
}

.prose p {
    margin-bottom: 1.25rem;
}

.prose ul {
    list-style-type: disc;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .about-hero-section {
        padding: 4rem 1.5rem;
    }
    
    .vision-mission-section,
    .special-section {
        padding: 3rem 1rem;
    }
}
</style>