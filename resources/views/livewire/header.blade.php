<div>
    <header class="header-area style-2" 
            x-data="{ 
                mobileMenuOpen: @entangle('isMobileMenuOpen'),
                darkMode: @entangle('isDarkMode'),
                activeDropdown: @entangle('activeDropdown')
            }"
            :class="{ 'dark-mode': darkMode }">
        <div class="container d-flex flex-nowrap align-items-center justify-content-between">
            <!-- Logo -->
            <div class="header-logo">
                <a href="{{ route('home') }}" wire:navigate>
                    <img alt="image" class="img-fluid light" src="{{ asset('images/logo.png') }}" style="height:100px">
                    <img alt="image" class="img-fluid dark" src="{{ asset('images/logo.png') }}" style="height:100px">
                </a>
            </div>

            <!-- Main Menu -->
            <div class="main-menu" :class="{ 'active': mobileMenuOpen }">
                <!-- Mobile Logo -->
                <div class="mobile-logo-area d-lg-none d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="mobile-logo-wrap" wire:navigate>
                        <img alt="image" class="img-fluid light" src="{{ asset('images/logo.png') }}" style="height:100px">
                        <img alt="image" class="img-fluid dark" src="{{ asset('images/logo.png') }}" style="height:100px">
                    </a>
                </div>

                <ul class="menu-list">
                    @foreach($menuItems as $key => $item)
                        @php
                            $isActive = $currentRoute === $item['route'];
                            $hasActiveChild = false;
                            foreach($item['children'] as $child) {
                                if ($currentRoute === $child['route']) {
                                    $hasActiveChild = true;
                                    break;
                                }
                            }
                            $isActiveOrChild = $isActive || $hasActiveChild;
                            $hasChildren = count($item['children']) > 0;
                        @endphp
                        
                        <li class="{{ $isActiveOrChild ? 'active' : '' }}
                                   {{ $hasChildren ? 'menu-item-has-children' : '' }}">
                            
                            @if($hasChildren)
                                <a href="#" class="drop-down" 
                                   @click.prevent="activeDropdown = activeDropdown === '{{ $key }}' ? null : '{{ $key }}'"
                                   x-bind:class="{ 'active': activeDropdown === '{{ $key }}' }">
                                    {{ $item['label'] }}
                                </a>
                                <i class="bi bi-plus dropdown-icon" 
                                   @click="activeDropdown = activeDropdown === '{{ $key }}' ? null : '{{ $key }}'"
                                   x-bind:class="{ 'rotated': activeDropdown === '{{ $key }}' }"></i>
                                
                                <ul class="sub-menu" 
                                    x-show="activeDropdown === '{{ $key }}'"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0">
                                    @foreach($item['children'] as $child)
                                        @php
                                            $isChildActive = $currentRoute === $child['route'];
                                        @endphp
                                        <li class="{{ $isChildActive ? 'active' : '' }}">
                                            <a href="{{ route($child['route']) }}" wire:navigate>
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a href="{{ route($item['route']) }}" wire:navigate
                                   class="{{ $isActive ? 'active' : '' }}">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Navigation Right -->
            <div class="nav-right">
                <!-- Dark/Light Switch -->
                <div class="dark-light-switch d-lg-none d-block" 
                     @click="darkMode = !darkMode; $wire.toggleDarkMode()">
                    <i class="bi bi-brightness-low-fill" 
                       x-bind:class="{ 'bi-brightness-low-fill': !darkMode, 'bi-moon-fill': darkMode }"></i>
                </div>

                <!-- Mobile Menu Button -->
                <div class="sidebar-button mobile-menu-btn" @click="mobileMenuOpen = !mobileMenuOpen">
                    <span></span>
                </div>
            </div>
        </div>

        <!-- Loading Indicator for Navigation -->
        <div wire:loading wire:target="navigate" 
             class="fixed top-0 left-0 right-0 h-1 bg-primary-500 z-50">
            <div class="h-full bg-gradient-to-r from-primary-400 to-primary-600 animate-progress"></div>
        </div>
    </header>

    @push('styles')
    <style>
        .sub-menu {
            display: none;
        }
        
        [x-cloak] {
            display: none !important;
        }
        
        .dropdown-icon.rotated {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
        
        .dropdown-icon {
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .animate-progress {
            animation: progress 1.5s ease-in-out infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        /* Dark Mode Styles */
        .dark-mode .header-area {
            background: #1a1a2e !important;
            border-bottom-color: #2d2d44 !important;
        }
        
        .dark-mode .menu-list > li > a {
            color: #e0e0e0 !important;
        }
        
        .dark-mode .menu-list > li > a:hover,
        .dark-mode .menu-list > li.active > a {
            color: #ff6b6b !important;
        }
        
        .dark-mode .sub-menu {
            background: #16213e !important;
        }
        
        .dark-mode .sub-menu li a {
            color: #e0e0e0 !important;
        }
        
        .dark-mode .sub-menu li a:hover {
            background: #1a1a2e !important;
            color: #ff6b6b !important;
        }
        
        .dark-mode .mobile-logo-area {
            background: #1a1a2e !important;
        }
        
        /* Mobile Menu Styles */
        .main-menu.active {
            transform: translateX(0) !important;
        }
        
        @media (max-width: 991px) {
            .main-menu {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: #fff;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 999;
                overflow-y: auto;
                padding: 80px 20px 20px;
            }
            
            .dark-mode .main-menu {
                background: #1a1a2e;
            }
            
            .mobile-logo-area {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                padding: 20px;
                background: #fff;
                border-bottom: 1px solid #eee;
            }
            
            .dark-mode .mobile-logo-area {
                background: #1a1a2e;
                border-bottom-color: #2d2d44;
            }
            
            .menu-list {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            
            .menu-list > li {
                width: 100%;
                text-align: center;
            }
            
            .sub-menu {
                position: static !important;
                box-shadow: none !important;
                background: #f8f9fa !important;
                padding: 10px 0 !important;
                margin-top: 10px !important;
                border-radius: 8px !important;
                display: none;
            }
            
            .dark-mode .sub-menu {
                background: #16213e !important;
            }
            
            .sub-menu li a {
                padding: 8px 20px !important;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function() {
            // Close mobile menu on navigation
            Livewire.on('navigated', () => {
                const menuBtn = document.querySelector('.mobile-menu-btn');
                if (menuBtn) {
                    menuBtn.click();
                }
            });
            
            // Handle dark mode toggle
            Livewire.on('darkModeToggled', (isDark) => {
                document.documentElement.classList.toggle('dark-mode', isDark);
                document.body.classList.toggle('dark-mode', isDark);
            });
            
            // Initialize dark mode from session
            const isDark = @json(session('dark_mode', false));
            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            }
        });
    </script>
    @endpush
</div>