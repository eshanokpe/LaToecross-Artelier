<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class Header extends Component
{
    public $currentRoute;
    public $isDarkMode = false;
    public $isMobileMenuOpen = false;
    public $activeDropdown = null;
    
    // Navigation structure
    public $menuItems = [
        'home' => [
            'label' => 'Home',
            'route' => 'home',
            'children' => []
        ],
        'about' => [
            'label' => 'About',
            'route' => 'about',
            'children' => []
        ], 
        'arkworks' => [
            'label' => 'Artworks',
            'route' => 'artworks.index',
            'children' => []
            // 'children' => [
            //     ['label' => 'Abstract Painting', 'route' => 'artworks.abstract.paintings'],
            //     ['label' => 'Landscape Painting', 'route' => 'artworks.landscape.paintings'],
            //     ['label' => 'Mixed Media Painting', 'route' => 'artworks.mixed-media.paintings'],
            //     ['label' => 'Figure Painting', 'route' => 'artworks.figure.paintings'],
            //     ['label' => 'Miniature', 'route' => 'artworks.miniature.paintings'],
            // ]
        ], 
        'fashion' => [
            'label' => 'Fashion',
            'route' => 'fashions.index',
            'children' => []
            // 'children' => [
            //     ['label' => 'Art You Wear', 'route' => 'fashion.art-wear'],
            //     ['label' => 'Bold Designs', 'route' => 'fashion.bold-designs'],
            //     ['label' => 'New Designs', 'route' => 'fashion.new-designs'],
            // ]
        ],
        'blog' => [
            'label' => 'Blog',
            'route' => 'blog',
            'children' => []
        ],
        'contact' => [
            'label' => 'Contact',
            'route' => 'contact',
            'children' => []
        ],
    ];

    protected $listeners = [
        'toggleDarkMode' => 'toggleDarkMode',
        'closeMobileMenu' => 'closeMobileMenu',
        'navigationUpdated' => '$refresh',
    ];

    public function mount()
    {
        $this->currentRoute = Route::currentRouteName() ?? 'home';
        $this->isDarkMode = session('dark_mode', false);
    }

    public function toggleDarkMode()
    {
        $this->isDarkMode = !$this->isDarkMode;
        session(['dark_mode' => $this->isDarkMode]);
        $this->dispatch('darkModeToggled', $this->isDarkMode);
    }

    public function toggleMobileMenu()
    {
        $this->isMobileMenuOpen = !$this->isMobileMenuOpen;
    }

    public function closeMobileMenu()
    {
        $this->isMobileMenuOpen = false;
    }

    public function toggleDropdown($menuKey)
    {
        if ($this->activeDropdown === $menuKey) {
            $this->activeDropdown = null;
        } else {
            $this->activeDropdown = $menuKey;
        }
    }

    // Helper methods for the view
    public function isActiveRoute($route)
    {
        return $this->currentRoute === $route;
    }

    public function isChildActive($children)
    {
        foreach ($children as $child) {
            if ($this->currentRoute === $child['route']) {
                return true;
            }
        }
        return false;
    }

    public function getRoute($route)
    {
        return route($route);
    }

    public function render()
    {
        return view('livewire.header', [
            'menuItems' => $this->menuItems,
            'currentRoute' => $this->currentRoute,
            'isDarkMode' => $this->isDarkMode,
            'isMobileMenuOpen' => $this->isMobileMenuOpen,
            'activeDropdown' => $this->activeDropdown,
        ]);
    }
}