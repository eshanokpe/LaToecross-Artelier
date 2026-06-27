<?php

use App\Models\Category;
use App\Models\Setting;
use Livewire\Component;

new class extends Component
{
    public $email = '';
    public $showSuccess = false;
    public $errorMessage = null;
    public $categories;
    public $settings;

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email address is too long.',
    ];

    public function mount(): void
    {
        // Get active categories
        $this->categories = Category::where('is_active', true)->take(6)->get();

        // Get all settings in one go
        $this->settings = [
            'about_content' => Setting::get('about_content'),
            'facebook_url'  => Setting::get('facebook_url'),
            'twitter_url'   => Setting::get('twitter_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'linkedin_url'  => Setting::get('linkedin_url'),
            'youtube_url'   => Setting::get('youtube_url'),
            'phone_1'       => Setting::get('phone_1'),
            'phone_2'       => Setting::get('phone_2'),
            'email_1'       => Setting::get('email_1'),
            'email_2'       => Setting::get('email_2'),
        ];
    }

    public function subscribe()
    {
        $this->validate();

        // TODO: Add newsletter subscription logic here
        // Example: Newsletter::subscribe($this->email);

        $this->showSuccess = true;
        $this->email = '';

        $this->dispatch('reset-success', delay: 5000);
    }
};
?>

<div>
   <!-- Home1 Footer Section Start -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-menu-wrap">
                <div class="row gy-5">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="footer-content-area">
                            <a href="{{ route('home') }}" class="footer-logo">
                                <img src="{{ asset('images/logo.png') }}" style="width:80px; align-items:center" alt="Artmart">
                            </a>
                            <!-- ✅ Dynamic About Us Content -->
                           <p class="footer-about-text">
                                {{ Str::limit($settings['about_content'] ?? 'An Art Action Company typically operates in the space of live art, performance, and social practice, often combining elements of activism and community engagement.', 120) }}

                                @if(strlen(trim(strip_tags($settings['about_content'] ?? ''))) > 120)
                                    <a href="{{ route('about') }}" class="read-more-link">Read More</a>
                                @endif
                            </p>

                            <!-- ✅ Contact Info: Phone & Email -->
                            <div class="footer-contact mt-3 mb-3">
                                @if(!empty($settings['phone_1']))
                                    <p><i class="bi bi-telephone me-2"></i> {{ $settings['phone_1'] }} @if(!empty($settings['phone_2'])) / {{ $settings['phone_2'] }} @endif</p>
                                @endif
                                @if(!empty($settings['email_1']))
                                    <p><i class="bi bi-envelope me-2"></i> {{ $settings['email_1'] }} @if(!empty($settings['email_2'])) / {{ $settings['email_2'] }} @endif</p>
                                @endif
                            </div>

                            <!-- ✅ Dynamic Social Media Links -->
                            <ul class="social-list">
                                @if(!empty($settings['facebook_url']))
                                    <li>
                                        <a href="{{ $settings['facebook_url'] }}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-facebook"></i>
                                            <span>Facebook</span>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($settings['instagram_url']))
                                    <li>
                                        <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-instagram"></i>
                                            <span>Instagram</span>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($settings['linkedin_url']))
                                    <li>
                                        <a href="{{ $settings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-linkedin"></i>
                                            <span>LinkedIn</span>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($settings['twitter_url']))
                                    <li>
                                        <a href="{{ $settings['twitter_url'] }}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-twitter-x"></i>
                                            <span>Twitter / X</span>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($settings['youtube_url']))
                                    <li>
                                        <a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-youtube"></i>
                                            <span>YouTube</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-4 d-flex justify-content-lg-end justify-content-md-center justify-content-sm-end">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h5>Menu</h5>
                            </div>
                            <ul class="widget-list">
                                <li>
                                    <a href="{{ route('artists-portfolio') }}">Artists Portfolio</a>
                                </li>
                                <li>
                                    <a href="{{ route('artwork.index') }}">Art Catalog</a>
                                </li>
                                <li>
                                    <a href="#">Departments</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-5 d-flex justify-content-md-end">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h5>Resources</h5>
                            </div>
                            <ul class="widget-list">
                                <li>
                                    <a href="{{ route('blog') }}">Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}">About us</a>
                                </li>
                                <li>
                                    <a href="{{ route('how-to-bid') }}">How to bid</a>
                                </li>
                                <li>
                                    <a href="{{ route('how-to-sell') }}">How to sell</a>
                                </li>
                                <li>
                                    <a href="{{ route('faq') }}">F.A.Q</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-7 d-flex justify-content-lg-end justify-content-md-center justify-content-sm-end">
                        <div class="newsletter-and-payment-area">
                            <h4>For Exclusive Art Updates Join Our Newsletter!</h4>

                            @if($showSuccess)
                                <div class="alert alert-success mt-2 mb-2" role="alert">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Thank you for subscribing!
                                </div>
                            @endif

                            <form wire:submit.prevent="subscribe">
                                <div class="form-inner">
                                    <input type="email" 
                                           wire:model="email" 
                                           placeholder="Email Address"
                                           class="form-control @error('email') is-invalid @enderror">
                                    <button type="submit" wire:loading.attr="disabled">
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>

                            <div class="payment-area mt-4">
                                <h6>Secured Payment Gateways</h6>
                                <ul class="payment-options">
                                    <li>
                                        <img src="{{ asset('assets/img/home1/icon/visa.svg') }}" alt="Visa">
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/img/home1/icon/master-card.svg') }}" alt="MasterCard">
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/img/home1/icon/american-express.svg') }}" alt="American Express">
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/img/home1/icon/maestro.svg') }}" alt="Maestro">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="copyright-area">
                    <p>
                        ©Copyright {{ date('Y') }} <a href="{{ route('home') }}">Artmart</a>
                        | Design By <a href="https://www.egenslab.com/" target="_blank" rel="noopener noreferrer">Egens Lab</a>
                    </p>
                </div>
                <div class="footer-bottom-right">
                    <ul>
                        <li>
                            <a href="{{ route('support') }}">Support Center</a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Home1 Footer Section End -->

    <style>
        .footer-contact p {
            margin: 0.3rem 0;
            font-size: 0.95rem;
            color: #666;
        }
        .footer-contact i {
            color: #ff6b6b;
        }
        .social-list a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #f5f5f5;
            border-radius: 50%;
            color: #333;
            transition: all 0.3s;
        }
        .social-list a:hover {
            background: #ff6b6b;
            color: #fff;
        }
    </style>
</div>