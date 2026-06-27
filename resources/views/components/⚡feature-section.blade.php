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

    public function mount(): void
    {
        $this->loadSettings();
    }

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

    public function getImageUrl(): string
    {
        return $this->whatMakesSpecialImage 
            ? asset('storage/' . $this->whatMakesSpecialImage)
            : asset('assets/img/placeholder.jpg');
    }

    public function hasContent(string $content): bool
    {
        return !empty($content) && $content !== 'Our vision statement will appear here once configured.';
    }
};
?>

<div class="feature-section-wrapper">
   


    <!-- Vision & Mission Section -->
    <section id="vision-section" class="vision-mission-section py-16 md:py-20" style="background: #faf0f5;">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="font-semibold text-sm uppercase tracking-wider" style="color: #DB2077;">Our Foundation</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">Driven by Purpose</h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Vision Card -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 md:p-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:opacity-75 transition-opacity duration-500" style="background: linear-gradient(135deg, #fce4ec, #f5d6e0);"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <h3 id="vision-heading" class="text-2xl font-bold" style="color: #1a0a0f;">Our Vision</h3>
                            </div>
                            <p class="leading-relaxed text-lg" style="color: #2d1b24;">
                                {{ $vision }}
                            </p>
                            <div class="mt-6 flex items-center font-medium" style="color: #DB2077;">
                                <span class="text-sm">Guiding our future</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Mission Card -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 md:p-10 relative overflow-hidden">
                        <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full translate-y-1/2 -translate-x-1/2 opacity-50 group-hover:opacity-75 transition-opacity duration-500" style="background: linear-gradient(135deg, #fce4ec, #f5d6e0);"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #ff6b9d, #ff9ec4);">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 id="mission-heading" class="text-2xl font-bold" style="color: #1a0a0f;">Our Mission</h3>
                            </div>
                            <p class="leading-relaxed text-lg" style="color: #2d1b24;">
                                {{ $mission }}
                            </p>
                            <div class="mt-6 flex items-center font-medium" style="color: #DB2077;">
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

    <!-- What Makes Us Special Section -->
    <section class="special-section py-16 md:py-20 bg-white" aria-labelledby="special-heading">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="font-semibold text-sm uppercase tracking-wider" style="color: #DB2077;">What Sets Us Apart</span>
                    <h2 id="special-heading" class="text-3xl md:text-4xl font-bold mt-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">Our Unique Value</h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Content Column -->
                    <div class="space-y-6">
                        <div class="prose prose-lg max-w-none">
                            <div class="leading-relaxed space-y-4" style="color: #2d1b24;">
                                {!! $whatMakesSpecial ?: '<p class="italic" style="color: #6b3b4f;">Our unique qualities and advantages will appear here once configured.</p>' !!}
                            </div>
                        </div>

                        <!-- Feature Points -->
                        <div class="grid sm:grid-cols-2 gap-4 pt-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #fce4ec;">
                                    <svg class="w-3.5 h-3.5" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2d1b24;">Authentic African Art</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #fce4ec;">
                                    <svg class="w-3.5 h-3.5" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2d1b24;">Curated Collections</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #fce4ec;">
                                    <svg class="w-3.5 h-3.5" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2d1b24;">Direct Artist Support</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #fce4ec;">
                                    <svg class="w-3.5 h-3.5" style="color: #DB2077;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm" style="color: #2d1b24;">Global Community</span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Column -->
                    <div class="relative">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <div class="absolute inset-0 mix-blend-overlay" style="background: linear-gradient(135deg, rgba(219, 32, 119, 0.2), rgba(255, 107, 157, 0.2));"></div>
                            <img src="{{ $this->getImageUrl() }}"
                                 alt="{{ $aboutTitle ?: 'What Makes Us Special' }}"
                                 class="w-full h-auto object-cover"
                                 loading="lazy">
                            <div class="absolute bottom-0 left-0 right-0 p-6" style="background: linear-gradient(180deg, transparent, rgba(26, 10, 15, 0.8));">
                                <p class="text-white text-sm font-medium" style="font-family: 'Georgia', serif;">Celebrating African Artistic Excellence</p>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 rounded-full opacity-50 -z-10" style="background: linear-gradient(135deg, #fce4ec, #f5d6e0);"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 rounded-full opacity-50 -z-10" style="background: linear-gradient(135deg, #fce4ec, #f5d6e0);"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-16 text-white" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 40%, #ff6b9d 70%, #ff9ec4 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: 'Georgia', serif;">Ready to Discover Amazing Art?</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto" style="color: #ffd6e8;">
                    Join our community of art lovers and collectors. Explore curated collections from Africa's most talented artists.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/artworks" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl" style="background: #ffffff; color: #DB2077;">
                        <span>Browse Artworks</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full transition-all duration-300" style="border: 2px solid #ffffff; color: #ffffff;">
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.feature-section-wrapper {
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

.container {
    max-width: 1280px;
}

html {
    scroll-behavior: smooth;
}

.group:hover .group-hover\:shadow-2xl {
    transform: translateY(-4px);
}

.bg-gradient-to-r {
    background-size: 200% 200%;
    animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.prose h1, .prose h2, .prose h3, .prose h4 {
    color: #1a0a0f;
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

@media (max-width: 768px) {
    .feature-hero-section {
        padding: 4rem 1.5rem;
    }
    
    .vision-mission-section,
    .special-section {
        padding: 3rem 1rem;
    }
}
</style>