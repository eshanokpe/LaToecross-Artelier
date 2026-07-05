@extends('layouts.app')

@section('title', 'Support Center - Latoecross Artelier')
@section('meta_description', 'Get help and support from Latocross Artelier. Browse our FAQ, contact our support team, or submit a support ticket.')

@section('content')
    <!-- Breadcrumb Section with Brand Color -->
    <section class="breadcrumb-section" style="background: linear-gradient(135deg, #1a0a0f 0%, #DB2077 50%, #ff6b9d 100%);">
        <div class="container mx-auto px-4 py-16 md:py-20">
            <div class="text-center max-w-3xl mx-auto">
                <nav aria-label="Breadcrumb" class="mb-4">
                    <ol class="flex flex-wrap items-center justify-center gap-2 text-sm text-pink-200">
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
                            <span class="text-white font-medium">Support Center</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                    Support Center
                </h1>
                <p class="text-pink-200 text-base md:text-lg max-w-2xl mx-auto">
                    We're here to help. Browse our FAQs, contact our support team, or submit a ticket.
                </p>
            </div>
        </div>
    </section>

    <!-- Support Content -->
    <section class="support-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Quick Help Cards -->
                <div class="grid md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-2xl transition-all duration-300 group" style="border-bottom: 4px solid #DB2077;">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" style="background: #fce4ec;">
                            <svg class="w-8 h-8" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold mb-2" style="color: #1a0a0f;">Browse FAQs</h4>
                        <p class="text-sm" style="color: #6b3b4f;">Find answers to common questions</p>
                        <a href="{{ route('faq') }}" class="inline-block mt-3 text-sm font-medium hover:underline" style="color: #DB2077;">
                            View FAQs →
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-2xl transition-all duration-300 group" style="border-bottom: 4px solid #ff6b9d;">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" style="background: #fce4ec;">
                            <svg class="w-8 h-8" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold mb-2" style="color: #1a0a0f;">Email Support</h4>
                        <p class="text-sm" style="color: #6b3b4f;">Reach out via email for assistance</p>
                        <a href="mailto:support@latocross.com" class="inline-block mt-3 text-sm font-medium hover:underline" style="color: #DB2077;">
                            support@latocross.com →
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-2xl transition-all duration-300 group" style="border-bottom: 4px solid #ff9ec4;">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" style="background: #fce4ec;">
                            <svg class="w-8 h-8" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold mb-2" style="color: #1a0a0f;">Phone Support</h4>
                        <p class="text-sm" style="color: #6b3b4f;">Speak with our support team</p>
                        <a href="tel:+2348000000000" class="inline-block mt-3 text-sm font-medium hover:underline" style="color: #DB2077;">
                            +234 800 000 0000 →
                        </a>
                    </div>
                </div>

                <!-- Support Ticket Form -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                    <div class="text-center mb-8">
                        <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                            Submit a Ticket
                        </span>
                        <h3 class="text-2xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                            How Can We Help You?
                        </h3>
                        <p class="text-sm mt-2" style="color: #6b3b4f;">
                            Fill in the form below and our support team will get back to you within 24 hours.
                        </p>
                        <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                    </div>

                    <form action="{{ route('support.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Success Message -->
                        @if(session('support_success'))
                            <div class="p-4 rounded-xl flex items-start gap-3" style="background: #f0fdf4; border: 1px solid #86efac;">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium" style="color: #166534;">Success!</p>
                                    <p class="text-sm" style="color: #15803d;">{{ session('support_success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="p-4 rounded-xl flex items-start gap-3" style="background: #fef2f2; border: 1px solid #fca5a5;">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium" style="color: #991b1b;">Please fix the following errors:</p>
                                    <ul class="text-sm" style="color: #dc2626;">
                                        @foreach($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Full Name <span style="color: #DB2077;">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Enter your full name"
                                   class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                    Email Address <span style="color: #DB2077;">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email address"
                                       class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                       style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                    Phone Number <span style="color: #6b3b4f;">(optional)</span>
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="Enter your phone number"
                                       class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                       style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Subject <span style="color: #DB2077;">*</span>
                            </label>
                            <select name="subject" 
                                    class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                    style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                                <option value="">Select a subject...</option>
                                <option value="order">Order Inquiry</option>
                                <option value="payment">Payment Issue</option>
                                <option value="shipping">Shipping & Delivery</option>
                                <option value="return">Returns & Refunds</option>
                                <option value="artwork">Artwork Inquiry</option>
                                <option value="technical">Technical Issue</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Message <span style="color: #DB2077;">*</span>
                            </label>
                            <textarea name="message" 
                                      rows="5"
                                      placeholder="Describe your issue in detail..."
                                      class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 resize-y"
                                      style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f; min-height: 120px;">{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full py-3.5 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Submit Ticket
                        </button>
                    </form>
                </div>

                <!-- Response Time Notice -->
                <div class="mt-8 text-center">
                    <div class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl" style="background: #fce4ec;">
                        <svg class="w-5 h-5" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium" style="color: #1a0a0f;">
                            Response Time: <span style="color: #DB2077;">Within 24 hours</span>
                        </span>
                    </div>
                </div>

                <!-- Alternative Contact Methods -->
                <div class="mt-12 grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                        <div class="flex items-center justify-center gap-3 mb-3">
                            <svg class="w-6 h-6" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="font-bold" style="color: #1a0a0f;">Live Chat</h4>
                        </div>
                        <p class="text-sm" style="color: #6b3b4f;">
                            Chat with our support team in real-time.
                        </p>
                        <p class="text-xs mt-1" style="color: #6b3b4f;">
                            Available Mon-Fri, 9AM - 6PM WAT
                        </p>
                        <!-- <button class="mt-3 px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:shadow-lg"
                                style="background: #fce4ec; color: #DB2077;">
                            Start Chat
                        </button> -->
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                        <div class="flex items-center justify-center gap-3 mb-3">
                            <svg class="w-6 h-6" style="color: #DB2077;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h4 class="font-bold" style="color: #1a0a0f;">Knowledge Base</h4>
                        </div>
                        <p class="text-sm" style="color: #6b3b4f;">
                            Browse our articles and guides.
                        </p>
                        <p class="text-xs mt-1" style="color: #6b3b4f;">
                            Available 24/7
                        </p>
                        <a href="{{ route('blog') }}" class="inline-block mt-3 px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:shadow-lg"
                           style="background: #fce4ec; color: #DB2077;">
                            Browse Articles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .support-section .prose {
            max-width: none;
        }

        .support-section .prose h1,
        .support-section .prose h2,
        .support-section .prose h3,
        .support-section .prose h4 {
            color: #1a0a0f;
            font-family: 'Georgia', serif;
        }

        .support-section .prose p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .support-section .prose ul {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .support-section .prose li {
            margin-bottom: 0.5rem;
        }

        .support-section .prose strong {
            color: #1a0a0f;
        }

        .support-section .prose a {
            color: #DB2077;
            text-decoration: underline;
        }

        .support-section .prose a:hover {
            opacity: 0.8;
        }

        /* Form focus styles */
        input:focus, select:focus, textarea:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        /* Card hover effects */
        .group:hover .group-hover\:shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }

            .support-section {
                padding: 2rem 1rem;
            }

            .support-section .grid.md\:grid-cols-3 {
                gap: 1.5rem;
            }

            .support-section .bg-white {
                padding: 1.5rem;
            }

            .support-section .grid.md\:grid-cols-2 {
                gap: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .support-section .grid.md\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            .support-section .grid.md\:grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .support-section .text-xl {
                font-size: 1.125rem;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }

            .support-section .bg-white {
                box-shadow: none !important;
                border: 1px solid #e5d0d8;
            }

            .support-section .bg-gray-50 {
                background: #faf0f5 !important;
            }

            form button {
                display: none !important;
            }
        }

        /* Focus styles */
        a:focus-visible, button:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }
    </style>
@endsection