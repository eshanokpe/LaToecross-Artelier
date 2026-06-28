<?php

use Livewire\Component;
use App\Models\Faq;

new class extends Component
{
    public $faqs = [];
    public $categories = [];
    public $selectedCategory = 'all';
    public $searchTerm = '';
    public $expandedFaq = null;

    public function mount()
    {
        $this->loadFaqs();
    }

    public function loadFaqs()
    {
        $query = Faq::where('is_active', true);

        // Category filter
        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        // Search filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('question', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('answer', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $this->faqs = $query->orderBy('sort_order', 'asc')->get();

        // Get unique categories
        $this->categories = Faq::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->toArray();
    }

    public function filterByCategory($category)
    {
        $this->selectedCategory = $category;
        $this->loadFaqs();
        $this->expandedFaq = null;
    }

    public function search()
    {
        $this->loadFaqs();
        $this->expandedFaq = null;
    }

    public function toggleFaq($id)
    {
        $this->expandedFaq = ($this->expandedFaq === $id) ? null : $id;
    }

    public function clearFilters()
    {
        $this->searchTerm = '';
        $this->selectedCategory = 'all';
        $this->loadFaqs();
        $this->expandedFaq = null;
    }
};
?>

<div class="faq-section-wrapper">
    <!-- FAQ Section -->
    <section class="faq-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Search & Filter -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="searchTerm"
                                   wire:keydown.enter="search"
                                   placeholder="Search for answers..."
                                   class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2"
                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f; padding-left: 44px;">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5" style="color: #6b3b4f;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <!-- Category Filter -->
                        <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0">
                            <button wire:click="filterByCategory('all')"
                                    class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-all duration-300"
                                    style="{{ $selectedCategory === 'all' 
                                        ? 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;' 
                                        : 'background: #fce4ec; color: #6b3b4f;' }}">
                                All
                            </button>
                            @foreach($categories as $category)
                                <button wire:click="filterByCategory('{{ $category }}')"
                                        class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-all duration-300"
                                        style="{{ $selectedCategory === $category 
                                            ? 'background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;' 
                                            : 'background: #fce4ec; color: #6b3b4f;' }}">
                                    {{ ucfirst($category) }}
                                </button>
                            @endforeach
                        </div>

                        @if($selectedCategory !== 'all' || !empty($searchTerm))
                            <button wire:click="clearFilters"
                                    class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 whitespace-nowrap"
                                    style="background: #fce4ec; color: #DB2077;">
                                Clear Filters
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Results Count -->
                @if(count($faqs) > 0)
                    <div class="text-sm mb-4" style="color: #6b3b4f;">
                        Showing <span class="font-bold" style="color: #DB2077;">{{ count($faqs) }}</span> 
                        {{ Str::plural('result', count($faqs)) }}
                        @if($selectedCategory !== 'all')
                            in <span class="font-bold" style="color: #DB2077;">{{ ucfirst($selectedCategory) }}</span>
                        @endif
                        @if(!empty($searchTerm))
                            for "<span class="font-bold" style="color: #DB2077;">{{ $searchTerm }}</span>"
                        @endif
                    </div>
                @endif

                <!-- FAQ Accordion -->
                @forelse($faqs as $faq)
                    <div class="bg-white rounded-2xl shadow-lg mb-4 overflow-hidden transition-all duration-300 hover:shadow-xl">
                        <!-- Question -->
                        <button wire:click="toggleFaq({{ $faq->id }})"
                                class="w-full px-6 py-4 flex items-center justify-between text-left transition-all duration-300 hover:bg-gray-50"
                                style="background: {{ $expandedFaq === $faq->id ? '#fce4ec' : 'white' }};">
                            <div class="flex items-center gap-3 flex-1">
                                @if($faq->category)
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background: #fce4ec; color: #DB2077;">
                                        {{ $faq->category }}
                                    </span>
                                @endif
                                <span class="font-medium" style="color: #1a0a0f;">
                                    {{ $faq->question }}
                                </span>
                            </div>
                            <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300" 
                                 style="color: #DB2077;"
                                 fill="none" 
                                 stroke="currentColor" 
                                 viewBox="0 0 24 24"
                                 transform="{{ $expandedFaq === $faq->id ? 'rotate(180deg)' : '' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Answer -->
                        <div class="transition-all duration-300 overflow-hidden"
                             style="max-height: {{ $expandedFaq === $faq->id ? '2000px' : '0' }};">
                            <div class="px-6 pb-6 pt-2" style="color: #2d1b24; line-height: 1.8;">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                        <svg class="w-20 h-20 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No FAQs Found</h4>
                        <p class="text-sm" style="color: #6b3b4f;">
                            @if(!empty($searchTerm) || $selectedCategory !== 'all')
                                Try adjusting your filters or search terms.
                            @else
                                No frequently asked questions available at the moment.
                            @endif
                        </p>
                        @if(!empty($searchTerm) || $selectedCategory !== 'all')
                            <button wire:click="clearFilters" 
                                    class="mt-4 px-6 py-2 rounded-xl font-medium transition-all duration-300 hover:shadow-lg"
                                    style="background: #fce4ec; color: #DB2077;">
                                Clear Filters
                            </button>
                        @endif
                    </div>
                @endforelse

                <!-- Still Have Questions -->
                <div class="mt-12 text-center bg-white rounded-2xl shadow-lg p-8" style="border: 2px solid #fce4ec;">
                    <svg class="w-12 h-12 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        Still Have Questions?
                    </h4>
                    <p class="text-sm mb-4" style="color: #6b3b4f;">
                        Can't find what you're looking for? We're here to help!
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('contact') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-xl hover:scale-105"
                           style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Us
                        </a>
                        <a href="{{ route('support') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-xl"
                           style="background: #fce4ec; color: #DB2077;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a5 5 0 01-7.072 0m0 0L2 21m2.829-2.829a5 5 0 010-7.072m0 0l2.829 2.829"/>
                            </svg>
                            Support Center
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .faq-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        /* Transition for accordion */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        /* Hover effects */
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* Focus styles */
        input:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        button:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Category filter scroll */
        .overflow-x-auto {
            scrollbar-width: thin;
            -ms-overflow-style: none;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #fce4ec;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #DB2077;
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }
            
            .faq-section {
                padding: 2rem 1rem;
            }

            .faq-section .bg-white {
                padding: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .faq-section .flex-col.md\:flex-row {
                gap: 0.75rem;
            }

            .faq-section .gap-2 {
                gap: 0.5rem;
            }

            .faq-section .px-6 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .faq-section .py-4 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }

            .faq-section .bg-white {
                box-shadow: none !important;
                border: 1px solid #e5d0d8;
            }

            button {
                display: none !important;
            }

            .faq-section [style*="max-height: 0"] {
                max-height: none !important;
            }
        }
    </style>
</div>