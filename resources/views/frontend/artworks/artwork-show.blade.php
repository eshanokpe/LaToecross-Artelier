@extends('layouts.app')

@section('title', $artwork->title . ' - Latoecross Artelier')
@section('meta_description', $artwork->description ?? 'Discover this exquisite artwork at Latocross Artelier.')

@section('content')
    <!-- Breadcrumb Section with Brand Color -->
    <section class="breadcrumb-section" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2" style="font-family: 'Georgia', serif;">
                        {{ $artwork->title }}
                    </h1>
                    <p class="text-pink-200 text-sm md:text-base">Discover the story behind this masterpiece</p>
                </div>
                <nav aria-label="Breadcrumb" class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm flex-wrap">
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
                            <a href="{{ route('artworks.index') }}" class="text-pink-200 hover:text-white transition-colors">Artworks</a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </li>
                        <li>
                            <span class="text-white font-medium truncate max-w-xs">{{ $artwork->title }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Artwork Details Livewire Component -->
    <livewire:artworks.artworks-details :artwork="$artwork" />
@endsection