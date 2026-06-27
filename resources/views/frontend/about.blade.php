@extends('layouts.app')

@section('title', 'Latocross Artelier - About Us')
@section('meta_description', 'Discover the story behind Latocross Artelier - your premier destination for contemporary African art, connecting artists with collectors worldwide.')

@section('content')
    <!-- Breadcrumb Section with Brand Color -->
    <section class="breadcrumb-section" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2" style="font-family: 'Georgia', serif;">About Us</h1>
                    <p class="text-pink-200 text-sm md:text-base">Discover the story behind Latocross Artelier</p>
                </div>
                <nav aria-label="Breadcrumb" class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="text-pink-200 hover:text-white transition-colors">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </li>
                        <li>
                            <span class="text-white font-medium">About Us</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Main About Content - Livewire Component -->
    <livewire:about-section2 />

    <!-- Vision & Mission Section - Livewire Component -->
    <livewire:feature-section />

    <!-- Why Choose Us Section -->
    <section class="why-choose-us py-16 md:py-20" style="background: #faf0f5;">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="font-semibold text-sm uppercase tracking-wider" style="color: #DB2077;">Why Choose Latocross</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">The Artelier Difference</h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center group" style="border-bottom: 4px solid #DB2077;">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="color: #1a0a0f;">Global Reach</h3>
                        <p class="text-gray-600 leading-relaxed">Connect with art lovers and collectors from around the world through our international platform.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center group" style="border-bottom: 4px solid #ff6b9d;">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #ff6b9d, #ff9ec4);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="color: #1a0a0f;">Authentic Art</h3>
                        <p class="text-gray-600 leading-relaxed">Every artwork is carefully curated and verified for authenticity and quality.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center group" style="border-bottom: 4px solid #ff9ec4;">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #ff9ec4, #ffc1dc);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="color: #1a0a0f;">Community Focus</h3>
                        <p class="text-gray-600 leading-relaxed">Support emerging artists and build meaningful connections within the art community.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section py-16 md:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="font-semibold text-sm uppercase tracking-wider" style="color: #DB2077;">Testimonials</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">What Our Community Says</h2>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="p-6 rounded-2xl transition-all duration-300 hover:shadow-lg" style="background: #faf0f5; border-left: 4px solid #DB2077;">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed mb-4">"Latocross Artelier has completely transformed how I discover and collect African art. The platform is intuitive and the curation is exceptional."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">TK</div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900 text-sm">Tunde Kehinde</p>
                                <p class="text-gray-500 text-xs">Art Collector, Lagos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="p-6 rounded-2xl transition-all duration-300 hover:shadow-lg" style="background: #faf0f5; border-left: 4px solid #ff6b9d;">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed mb-4">"As an emerging artist, Latocross Artelier has given me a platform to showcase my work to a global audience. The support has been incredible."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #ff6b9d, #ff9ec4);">AO</div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900 text-sm">Amara Okafor</p>
                                <p class="text-gray-500 text-xs">Visual Artist, Enugu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="p-6 rounded-2xl transition-all duration-300 hover:shadow-lg" style="background: #faf0f5; border-left: 4px solid #ff9ec4;">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed mb-4">"The curated selection at Latocross Artelier is outstanding. I've discovered artists I would never have found otherwise."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #ff9ec4, #ffc1dc);">IC</div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900 text-sm">Ibrahim Chukwudi</p>
                                <p class="text-gray-500 text-xs">Gallery Owner, Abuja</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section with Brand Color -->
    <section class="final-cta py-16 text-white" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 40%, #ff6b9d 70%, #ff9ec4 100%);">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: 'Georgia', serif;">Join Our Artistic Journey</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto" style="color: #ffd6e8;">
                Whether you're an artist looking to showcase your work or a collector seeking unique pieces, Latocross Artelier is your gateway to the vibrant world of African art.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('artworks.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl" style="background: #ffffff; color: #DB2077;">
                    <span>Explore Artworks</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full transition-all duration-300" style="border: 2px solid #ffffff; color: #ffffff;">
                    <span>Get In Touch</span>
                </a>
                <a href="{{ route('fashions.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl" style="background: #ffffff; color: #DB2077;">
                    <span>Explore Fashion</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

@endsection