<?php

use Livewire\Component;
use App\Models\Article;

new class extends Component
{
    public $articles = [];
    public $currentPage = 1;
    public $itemsPerPage = 6;
    public $lastPage = 1;

    public function mount()
    {
        $this->loadArticles();
    }

    public function loadArticles()
    {
        // Get paginated data but extract ONLY what we need (array format)
        $paginated = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);

        // Convert to simple array — Livewire supports this
        $this->articles = $paginated->items();
        $this->lastPage = $paginated->lastPage();
    }

    public function goToPage($page)
    {
        $this->currentPage = $page;
        $this->loadArticles();
    }

    public function prevPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadArticles();
        }
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->lastPage) {
            $this->currentPage++;
            $this->loadArticles();
        }
    }
};
?>

<div>
    <div class="articel-section mb-120 style-2">
        <div class="container">
            <div class="row justify-content-center gy-5">
                @if(count($articles) === 0)
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No articles published yet.</p>
                    </div>
                @else
                    @foreach ($articles as $index => $article)
                        @php
                            $delays = ['200ms', '400ms', '600ms', '800ms', '800ms', '600ms'];
                            $delay = $delays[$index % 6];
                        @endphp
                        <div 
                            class="col-lg-4 col-md-6 wow animate fadeInDown" 
                            data-wow-delay="{{ $delay }}" 
                            data-wow-duration="1500ms"
                        >
                            <div class="article-card">
                               <a href="/article-details/{{ $article['slug'] }}" class="article-img" style="width: 100%; height: 330px; display: block; overflow: hidden;">
                                    <img 
                                        src="{{ asset('storage/' . $article['image']) }}" 
                                        alt="{{ $article['title'] }}"
                                        style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                    >
                                </a>
                                <div class="article-content-wrap">
                                    <div class="article-content">
                                        <div class="blog-meta">
                                            <a href="/article-grid" class="blog-date">
                                                {{ \Carbon\Carbon::parse($article['published_at'])->format('d F, Y') }}
                                            </a>
                                            <div class="blog-comment">
                                                <span>{{ $article['comments_count'] }} Comments</span>
                                            </div>
                                        </div>
                                        <h6>
                                            <a href="/article-details/{{ $article['slug'] }}">
                                                {{ $article['title'] }}
                                            </a>
                                        </h6>
                                        <a href="/article-details/{{ $article['slug'] }}" class="read-btn">Read Article</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if ($lastPage > 1)
            <div class="row wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="col-lg-12">
                    <div class="page-navigation-area d-flex flex-wrap align-items-center justify-content-between">
                        <div class="prev-next-btn">
                            <a 
                                href="#" 
                                wire:click.prevent="prevPage"
                                class="{{ $currentPage == 1 ? 'opacity-50 pointer-events-none' : '' }}"
                            >
                                <svg width="7" height="14" viewBox="0 0 7 14" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 7.00008L7 0L2.54545 7.00008L7 14L0 7.00008Z"/>
                                </svg> 
                                prev
                            </a>
                        </div>
                        <ul class="pagination">
                            @for ($i = 1; $i <= $lastPage; $i++)
                                <li class="{{ $currentPage == $i ? 'active' : '' }}">
                                    <a href="#" wire:click.prevent="goToPage({{ $i }})">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </a>
                                </li>
                            @endfor
                        </ul>
                        <div class="prev-next-btn">
                            <a 
                                href="#" 
                                wire:click.prevent="nextPage"
                                class="{{ $currentPage == $lastPage ? 'opacity-50 pointer-events-none' : '' }}"
                            >
                                next
                                <svg width="7" height="14" viewBox="0 0 7 14" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 7.00008L0 0L4.45455 7.00008L0 14L7 7.00008Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>