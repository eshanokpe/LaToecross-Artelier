@extends('layouts.app')

@section('title', $article->title . ' - Latoecross Artelier')
@section('meta_description', $article->excerpt ?? 'Read this article from Latocross Artelier.')

@section('content')
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="max-w-4xl mx-auto">
                <nav aria-label="Breadcrumb" class="mb-4">
                    <ol class="flex flex-wrap items-center gap-2 text-sm text-pink-200">
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
                            <a href="{{ route('blog') }}" class="hover:text-white transition-colors">Blog</a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </li>
                        <li>
                            <span class="text-white font-medium truncate max-w-xs">{{ $article->title }}</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                    {{ $article->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-pink-200 text-sm">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $article->author }}
                    </span>
                    <span class="opacity-50">|</span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $article->published_at->format('F j, Y') }}
                    </span>
                    @if($article->category)
                        <span class="opacity-50">|</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full" style="background: rgba(255,255,255,0.15); color: white;">
                            {{ $article->category }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="article-details py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Featured Image -->
                @if($article->image)
                    <div class="rounded-2xl overflow-hidden shadow-xl mb-8">
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             alt="{{ $article->title }}"
                             class="w-full h-auto object-cover">
                    </div>
                @endif

                <!-- Article Body -->
                <div class="prose prose-lg max-w-none" style="color: #2d1b24;">
                    {!! $article->content !!}
                </div>

                <!-- Share Section -->
                <div class="mt-12 pt-8 border-t" style="border-color: #fce4ec;">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="font-medium" style="color: #1a0a0f;">Share this article:</span>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
                               style="background: #1877F2; color: white;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                               target="_blank"
                               class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
                               style="background: #000000; color: white;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
                               style="background: #0A66C2; color: white;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode('Read this article: ' . url()->current()) }}" 
                               class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
                               style="background: #EA4335; color: white;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
                                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Back to Blog -->
                <div class="mt-6 text-center">
                    <a href="{{ route('blog') }}" 
                       class="inline-flex items-center gap-2 font-medium transition-all duration-300 hover:gap-3"
                       style="color: #DB2077;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Blog
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Articles -->
    @if(isset($relatedArticles) && $relatedArticles->count() > 0)
        <section class="related-articles py-12" style="background: #faf0f5;">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                            You May Also Like
                        </h3>
                        <div class="w-24 h-1 mx-auto mt-3 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $related)
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('article.show', $related->slug) }}">
                                        <img src="{{ asset('storage/' . $related->image) }}" 
                                             alt="{{ $related->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700"
                                             loading="lazy">
                                    </a>
                                </div>
                                <div class="p-5">
                                    <h6 class="font-bold line-clamp-1" style="color: #1a0a0f;">
                                        <a href="{{ route('article.show', $related->slug) }}" class="hover:underline">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <p class="text-sm line-clamp-2 mt-1" style="color: #6b3b4f;">
                                        {{ $related->excerpt ?? Str::limit(strip_tags($related->content ?? ''), 100) }}
                                    </p>
                                    <a href="{{ route('article.show', $related->slug) }}" 
                                       class="inline-flex items-center gap-2 mt-3 text-sm font-medium transition-all duration-300 hover:gap-3"
                                       style="color: #DB2077;">
                                        Read More
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <style>
        .prose h1, .prose h2, .prose h3, .prose h4 {
            color: #1a0a0f;
            font-family: 'Georgia', serif;
        }
        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
        }
        .prose img {
            border-radius: 12px;
            margin: 2rem 0;
        }
        .prose ul, .prose ol {
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose blockquote {
            border-left: 4px solid #DB2077;
            padding-left: 1.5rem;
            font-style: italic;
            color: #6b3b4f;
            margin: 1.5rem 0;
        }
        .prose a {
            color: #DB2077;
            text-decoration: underline;
        }
        .prose a:hover {
            opacity: 0.8;
        }
    </style>
</div>
@endsection