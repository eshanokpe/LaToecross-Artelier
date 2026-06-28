<?php

use App\Models\Fashion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component
{
    use WithPagination;

    // Search and Filter Properties
    #[Url(as: 'search')]
    public string $search = '';

    #[Url(as: 'category')]
    public string $category = 'all';

    #[Url(as: 'price_min')]
    public ?string $priceMin = null;

    #[Url(as: 'price_max')]
    public ?string $priceMax = null;

    #[Url(as: 'sort')]
    public string $sort = 'latest';

    // View mode
    public string $viewMode = 'grid';

    // Categories for Fashion
    public array $categories = [
        'all' => 'All Fashion',
        'men' => "Men's Wear",
        'ladies' => 'Ladies Wear',
        'unisex' => 'Unisex',
        'kids' => "Kids Wear",
        'painting_on_wear' => 'Painting on Wears',
        'fabric' => 'Fabric',
        'asooke' => 'Asooke',
        'etc' => 'Others',
    ];

    // Sort options
    public array $sortOptions = [
        'latest' => 'Latest',
        'price_low' => 'Price: Low to High',
        'price_high' => 'Price: High to Low',
        'title_asc' => 'Title A-Z',
        'title_desc' => 'Title Z-A',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all'],
        'priceMin' => ['except' => ''],
        'priceMax' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingPriceMin()
    {
        $this->resetPage();
    }

    public function updatingPriceMax()
    {
        $this->resetPage();
    }

    public function filterByCategory($category)
    {
        $this->category = $category;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = 'all';
        $this->priceMin = null;
        $this->priceMax = null;
        $this->sort = 'latest';
        $this->resetPage();
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'list' : 'grid';
    }

    public function getFashionsProperty()
    {
        $query = Fashion::query();

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('designer', 'like', '%' . $this->search . '%')
                  ->orWhere('material', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        // Price range filter
        if (!empty($this->priceMin)) {
            $query->where('price', '>=', (float) $this->priceMin);
        }
        if (!empty($this->priceMax)) {
            $query->where('price', '<=', (float) $this->priceMax);
        }

        // Sorting
        switch ($this->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query->paginate(12);
    }

    public function getTotalCountProperty()
    {
        return Fashion::count();
    }
};
?>

<div class="fashions-catalog-wrapper">
    <!-- Catalog Section -->
    <section class="auction-card-sidebar-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-4 gap-8">
                    <!-- Sidebar Column -->
                    <div class="lg:col-span-1 order-2 lg:order-1">
                        <div class="sidebar-area space-y-6">
                            <!-- Search Widget -->
                            <div class="single-widgets bg-white rounded-2xl shadow-lg p-6">
                                <div class="widget-title mb-4">
                                    <h5 class="font-bold text-lg" style="color: #1a0a0f;">Search Fashion</h5>
                                </div>
                                <form wire:submit.prevent>
                                    <div class="relative">
                                        <input type="search" 
                                               wire:model.live.debounce.300ms="search"
                                               placeholder="Search fashions..." 
                                               class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2"
                                               style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2" style="color: #DB2077;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Category Widget -->
                            <div class="single-widgets bg-white rounded-2xl shadow-lg p-6">
                                <div class="widget-title mb-4">
                                    <h5 class="font-bold text-lg" style="color: #1a0a0f;">Category</h5>
                                </div>
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    @foreach($this->categories as $key => $label)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" 
                                                   wire:click="filterByCategory('{{ $key }}')"
                                                   {{ $category === $key ? 'checked' : '' }}
                                                   class="w-4 h-4 rounded focus:ring-2"
                                                   style="accent-color: #DB2077;">
                                            <span class="text-sm group-hover:pl-1 transition-all" style="color: {{ $category === $key ? '#DB2077' : '#6b3b4f' }}">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Filter Widget -->
                            <div class="single-widgets bg-white rounded-2xl shadow-lg p-6">
                                <div class="widget-title mb-4">
                                    <h5 class="font-bold text-lg" style="color: #1a0a0f;">Price Range</h5>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs" style="color: #6b3b4f;">Min Price (₦)</label>
                                            <input type="number" 
                                                   wire:model.live="priceMin"
                                                   placeholder="0"
                                                   class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring-2 text-sm"
                                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                                        </div>
                                        <div>
                                            <label class="text-xs" style="color: #6b3b4f;">Max Price (₦)</label>
                                            <input type="number" 
                                                   wire:model.live="priceMax"
                                                   placeholder="1000000"
                                                   class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring-2 text-sm"
                                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                                        </div>
                                    </div>
                                    <button wire:click="clearFilters" 
                                            class="w-full py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:shadow-lg"
                                            style="background: #fce4ec; color: #DB2077;">
                                        Clear Filters
                                    </button>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="single-widgets rounded-2xl p-6" style="background: linear-gradient(135deg, #fce4ec, #faf0f5);">
                                <div class="text-center">
                                    <div class="text-3xl font-bold" style="color: #DB2077;">{{ $this->totalCount }}</div>
                                    <p class="text-sm" style="color: #6b3b4f;">Total Fashion Items</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Column -->
                    <div class="lg:col-span-3 order-1 lg:order-2">
                        <!-- Top Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white rounded-2xl shadow-lg p-4">
                            <div>
                                <h6 class="text-sm" style="color: #6b3b4f;">
                                    Showing 
                                    <span class="font-bold" style="color: #DB2077;">{{ $this->fashions->firstItem() ?? 0 }}</span>
                                    of 
                                    <span class="font-bold" style="color: #DB2077;">{{ $this->fashions->total() }}</span>
                                    results
                                </h6>
                            </div>
                            <div class="flex items-center gap-3">
                                <!-- Sort Dropdown -->
                                <select wire:model.live="sort" 
                                        class="px-4 py-2 rounded-xl border focus:outline-none focus:ring-2 text-sm"
                                        style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                                    @foreach($this->sortOptions as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>

                                <!-- View Toggle -->
                                <button wire:click="toggleViewMode" 
                                        class="p-2 rounded-xl transition-all duration-300 hover:scale-105"
                                        style="background: {{ $viewMode === 'grid' ? '#DB2077' : '#fce4ec' }}; color: {{ $viewMode === 'grid' ? 'white' : '#6b3b4f' }};">
                                    @if($viewMode === 'grid')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10-10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                    @endif
                                </button>
                            </div>
                        </div>

                        <!-- Fashions Grid -->
                        <div class="grid {{ $viewMode === 'grid' ? 'grid-cols-1 sm:grid-cols-3 xl:grid-cols-3' : 'grid-cols-1' }} gap-6">
                            @forelse($this->fashions as $fashion)
                                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden {{ $viewMode === 'list' ? 'flex flex-col sm:flex-row' : '' }}">
                                    <!-- Image -->
                                    <div class="relative overflow-hidden {{ $viewMode === 'list' ? 'sm:w-48 flex-shrink-0' : '' }}">
                                        <a href="{{ route('fashion.show', $fashion) }}">
                                            <img src="{{ $fashion->image ? asset('storage/' . $fashion->image) : asset('assets/img/placeholder-fashion.jpg') }}" 
                                                 alt="{{ $fashion->title }}"
                                                 class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
                                        </a>
                                        
                                        <!-- Status Badges -->
                                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                            @if($fashion->is_for_sale)
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                      style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                                    For Sale
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                      style="background: #1a0a0f; color: white;">
                                                    Sold Out
                                                </span>
                                            @endif
                                            @if($fashion->is_featured)
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                                      style="background: #fce4ec; color: #DB2077;">
                                                    ★ Featured
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Category Tag -->
                                        <span class="absolute bottom-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider"
                                              style="background: rgba(26, 10, 15, 0.8); color: white; backdrop-filter: blur(4px);">
                                            {{ $this->categories[$fashion->category] ?? $fashion->category }}
                                        </span>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-3 flex-1 flex flex-col">
                                        <h6 class="font-bold line-clamp-1" style="color: #1a0a0f;">
                                            <a href="{{ route('fashion.show', $fashion) }}" class="hover:underline">
                                                {{ $fashion->title }}
                                            </a>
                                        </h6>
                                        
                                        <div class="space-y-1 mt-2 text-sm">
                                            <p>
                                                <span style="color: #6b3b4f;">Dimensions:</span>
                                                <span style="color: #1a0a0f; font-weight: 500;">
                                                    {{ $fashion->dimensions ?? 'Unknown' }}
                                                </span>
                                            </p>
                                            @if($fashion->material)
                                                <p>
                                                    <span style="color: #6b3b4f;">Material:</span>
                                                    <span style="color: #1a0a0f;">{{ $fashion->material }}</span>
                                                </p>
                                            @endif
                                            <p>
                                                <span style="color: #6b3b4f;">Price:</span>
                                                <span style="color: #DB2077; font-weight: 600;">
                                                    @if($fashion->is_for_sale && $fashion->price)
                                                        ₦{{ number_format($fashion->price, 2) }}
                                                    @else
                                                        <span style="color: #6b3b4f;">Not for sale</span>
                                                    @endif
                                                </span>
                                            </p>
                                        </div>

                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('fashion.show', $fashion) }}" 
                                               class="flex-1 text-center py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:shadow-lg"
                                               style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-lg">
                                    <svg class="w-16 h-16 mx-auto mb-4" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h4 class="text-xl font-bold mb-2" style="color: #1a0a0f;">No Fashion Items Found</h4>
                                    <p class="text-gray-600" style="color: #6b3b4f;">
                                        @if(!empty($this->search) || $this->category !== 'all')
                                            Try adjusting your filters or search terms.
                                        @else
                                            No fashion items are available at the moment.
                                        @endif
                                    </p>
                                    <button wire:click="clearFilters" 
                                            class="mt-4 px-6 py-2 rounded-xl font-medium transition-all duration-300 hover:shadow-lg"
                                            style="background: #fce4ec; color: #DB2077;">
                                        Clear Filters
                                    </button>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if($this->fashions->hasPages())
                            <div class="mt-8">
                                {{ $this->fashions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .fashions-catalog-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .duration-500 {
            transition-duration: 500ms;
        }

        .duration-700 {
            transition-duration: 700ms;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:scale-110:hover {
            transform: scale(1.1);
        }

        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .hover\:shadow-2xl:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Category scroll */
        .max-h-64 {
            max-height: 16rem;
        }
        .overflow-y-auto {
            overflow-y: auto;
        }

        /* Custom scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #fce4ec;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #DB2077;
            border-radius: 10px;
        }

        /* Focus styles for inputs */
        input:focus, select:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        /* Checkbox styling */
        input[type="checkbox"]:checked {
            accent-color: #DB2077;
        }

        /* Line clamp */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination styling */
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            border: 2px solid #fce4ec;
            color: #6b3b4f;
            background: white;
        }

        .pagination .page-item.active .page-link {
            background: #DB2077;
            border-color: #DB2077;
            color: white;
        }

        .pagination .page-item .page-link:hover:not(.active) {
            border-color: #DB2077;
            color: #DB2077;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }
            
            .auction-card-sidebar-section {
                padding: 2rem 1rem;
            }

            .sidebar-area {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 640px) {
            .sidebar-area {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-1.sm\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }
            
            .sidebar-area {
                display: none !important;
            }
            
            .pagination {
                display: none !important;
            }
        }
    </style>
</div>