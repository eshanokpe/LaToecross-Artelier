@extends('layouts.app')

@section('title', 'Latoecross Artelier - Home')
@section('meta_description', 'Discover exceptional contemporary African art at Latocross Artelier. Explore curated collections, connect with artists, and find your next masterpiece.')

@section('content')
    <!-- 1. Hero Slider -->
    <livewire:home-slider />

    <!-- 2. Categories/Collections Section -->
    <section class="categories-section py-16 md:py-20" style="background: #FFFFFF;">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        Browse Categories
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        Explore by Category
                    </h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach([
                        ['name' => 'Abstract', 'icon' => '🎨', 'color' => '#DB2077'],
                        ['name' => 'Landscape', 'icon' => '🏔️', 'color' => '#ff6b9d'],
                        ['name' => 'Mixed Media', 'icon' => '🖼️', 'color' => '#ff9ec4'],
                        ['name' => 'Figure', 'icon' => '👤', 'color' => '#DB2077'],
                        ['name' => 'Miniature', 'icon' => '🔍', 'color' => '#ff6b9d'],
                        ['name' => 'Fashion', 'icon' => '👗', 'color' => '#ff9ec4'],
                    ] as $category)
                        <a href="{{ route('artworks.index', ['category' => strtolower($category['name'])]) }}" 
                           class="group p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-xl hover:scale-105"
                           style="background: #faf0f5;">
                            <div class="text-3xl mb-2">{{ $category['icon'] }}</div>
                            <h4 class="font-medium text-sm" style="color: #1a0a0f;">{{ $category['name'] }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 3. About Section -->
    <livewire:about-section />

    <!-- 4. Artworks Slider -->
    <livewire:art-section-slider />

    <!-- 5. Stats/Counter Section -->
    <section class="stats-section py-16" style="background: linear-gradient(135deg, #1a0a0f 0%, #2d1520 50%, #1a0a0f 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold" style="color: #DB2077;">50+</div>
                        <p class="text-sm mt-2" style="color: #cdb4c8;">Artists</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold" style="color: #DB2077;">200+</div>
                        <p class="text-sm mt-2" style="color: #cdb4c8;">Artworks</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold" style="color: #DB2077;">1000+</div>
                        <p class="text-sm mt-2" style="color: #cdb4c8;">Collectors</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold" style="color: #DB2077;">4.9★</div>
                        <p class="text-sm mt-2" style="color: #cdb4c8;">Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Fashion Slider -->
    <livewire:fashions.fashion-section-slider />

    <!-- 7. Testimonials Section -->
    <section class="testimonials-section py-16 md:py-20" style="background: #faf0f5;">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        Testimonials
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        What Our Collectors Say
                    </h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex text-yellow-400 mb-3">★★★★★</div>
                        <p class="text-sm" style="color: #2d1b24;">"Latocross Artelier has completely transformed how I discover and collect African art."</p>
                        <div class="mt-4">
                            <p class="font-semibold text-sm" style="color: #1a0a0f;">Tunde Kehinde</p>
                            <p class="text-xs" style="color: #6b3b4f;">Art Collector, Lagos</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex text-yellow-400 mb-3">★★★★★</div>
                        <p class="text-sm" style="color: #2d1b24;">"The curated selection is outstanding. I've discovered artists I would never have found otherwise."</p>
                        <div class="mt-4">
                            <p class="font-semibold text-sm" style="color: #1a0a0f;">Amara Okafor</p>
                            <p class="text-xs" style="color: #6b3b4f;">Visual Artist, Enugu</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <div class="flex text-yellow-400 mb-3">★★★★★</div>
                        <p class="text-sm" style="color: #2d1b24;">"A platform that truly celebrates African artistic excellence. Highly recommended!"</p>
                        <div class="mt-4">
                            <p class="font-semibold text-sm" style="color: #1a0a0f;">Ibrahim Chukwudi</p>
                            <p class="text-xs" style="color: #6b3b4f;">Gallery Owner, Abuja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Blog Slider -->
    <livewire:blog-section-slider />

    <!-- 9. Newsletter CTA -->
    <section class="newsletter-cta py-16" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                    Never Miss an Update
                </h2>
                <p class="text-pink-200 mb-6">
                    Subscribe to our newsletter and get the latest art stories delivered to your inbox.
                </p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" 
                           placeholder="Enter your email"
                           class="flex-1 px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-white/50"
                           style="background: rgba(255,255,255,0.1); color: white;">
                    <button type="submit" 
                            class="px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-lg hover:scale-105"
                            style="background: white; color: #DB2077;">
                        Subscribe
                    </button>
                </form>
                <p class="text-xs mt-3" style="color: rgba(255,255,255,0.5);">
                    No spam. Unsubscribe anytime.
                </p>
            </div>
        </div>
    </section>
@endsection