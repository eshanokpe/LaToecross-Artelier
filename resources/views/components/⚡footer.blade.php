<?php

use App\Models\Category;
use Livewire\Component;

new class extends Component
{
    public $email = '';
    public $showSuccess = false;
    public $errorMessage = null;
    public $categories;

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
        $this->categories = Category::where('is_active', true)->take(6)->get();
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
                            <a href="index.html" class="footer-logo">
                                <img src="assets/img/footer-logo.svg" alt="">
                            </a>
                            <p>An Art Action Company typically operates in the space of live art, performance, and
                            social practice, often combining elements of activism and community engagement.</p>
                            <ul class="social-list">
                                <li>
                                    <a href="https://www.facebook.com/">
                                        <i class="bi bi-facebook"></i>
                                        <span>Facebook</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/">
                                        <i class="bi bi-instagram"></i>
                                        <span>Instagram</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/">
                                        <i class="bi bi-linkedin"></i>
                                        <span>LinkedIn</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/">
                                        <i class="bi bi-twitter-x"></i>
                                        <span>Twitter</span>
                                    </a>
                                </li>
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
                                    <a href="artists-portfolio.html">Artists Portfolio</a>
                                </li>
                                <li>
                                    <a href="general-art-details.html">Art Catalog</a>
                                </li>
                                <li>
                                    <a href="#">Departments</a>
                                </li>
                                <li>
                                    <a href="contact.html">Contact</a>
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
                                    <a href="auction-grid.html">Blog</a>
                                </li>
                                <li>
                                    <a href="about.html">About us</a>
                                </li>
                                <li>
                                    <a href="how-to-bid.html">How to bid</a>
                                </li>
                                <li>
                                    <a href="how-to-sell.html">How to sell</a>
                                </li>
                                <li>
                                    <a href="faq.html">F.A.Q</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-7 d-flex justify-content-lg-end justify-content-md-center justify-content-sm-end">
                        <div class="newsletter-and-payment-area">
                            <h4>For Exclusive Art Updates Join Our Newsletter!</h4>
                            <form>
                                <div class="form-inner">
                                    <input type="email" placeholder="Email Address">
                                    <button type="submit">
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="payment-area">
                                <h6>Secured Payment Gateways</h6>
                                <ul class="payment-options">
                                    <li>
                                        <img src="assets/img/home1/icon/visa.svg" alt="">
                                    </li>
                                    <li>
                                        <img src="assets/img/home1/icon/master-card.svg" alt="">
                                    </li>
                                    <li>
                                        <img src="assets/img/home1/icon/american-express.svg" alt="">
                                    </li>
                                    <li>
                                        <img src="assets/img/home1/icon/maestro.svg" alt="">
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
                        ©Copyright 2024 <a href="index.html">Artmart</a>
                        | Design By <a href="https://www.egenslab.com/">Egens Lab</a>
                    </p>
                </div>
                <div class="footer-bottom-right">
                    <ul>
                        <li>
                            <a href="#">Support Center</a>
                        </li>
                        <li>
                            <a href="terms-condition.html">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="privacy-policy.html">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Home1 Footer Section End -->

</div>