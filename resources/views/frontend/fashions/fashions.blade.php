@extends('layouts.app')

@section('title', 'Art Catalog - Latocross Artelier')
@section('meta_description', 'Explore our curated collection of contemporary African art at Latocross Artelier. Discover unique artworks from talented artists.')

@section('content')
    <!-- Breadcrumb Section with Brand Color -->
    <section class="breadcrumb-section" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4 py-16 md:py-20">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center md:text-left">
                        <nav aria-label="Breadcrumb" class="mb-4">
                            <ol class="flex flex-wrap items-center justify-center md:justify-start gap-2 text-sm text-pink-200">
                                <li>
                                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">
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
                                    <span class="text-white font-medium">Fashions Catalog</span>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                            Fashions Catalog
                        </h1>
                        <p class="text-pink-200 text-base md:text-lg max-w-2xl mx-auto md:mx-0">
                            Explore our curated collection of original fashions, handpicked for the discerning collector.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Artworks Livewire Component -->
    <livewire:fashions.fashions />
@endsection 