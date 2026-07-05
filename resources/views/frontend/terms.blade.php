@extends('layouts.app')

@section('title', 'Terms & Conditions - Latoecross Artelier')
@section('meta_description', 'Read our terms and conditions to understand the rules and guidelines for using Latocross Artelier website and services.')

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
                            <span class="text-white font-medium">Terms & Conditions</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                    Terms & Conditions
                </h1>
                <p class="text-pink-200 text-base md:text-lg max-w-2xl mx-auto">
                    Please read these terms carefully before using our website and services.
                </p>
                <div class="mt-4 text-sm text-pink-300">
                    Last Updated: {{ date('F j, Y') }}
                </div>
            </div>
        </div>
    </section>

    <!-- Terms & Conditions Content -->
    <section class="terms-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Table of Contents -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" style="border-left: 4px solid #DB2077;">
                    <h3 class="text-lg font-bold mb-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        Table of Contents
                    </h3>
                    <ul class="grid md:grid-cols-2 gap-2 text-sm">
                        <li>
                            <a href="#section-1" class="hover:underline" style="color: #DB2077;">
                                1. Acceptance of Terms
                            </a>
                        </li>
                        <li>
                            <a href="#section-2" class="hover:underline" style="color: #DB2077;">
                                2. Use of Website
                            </a>
                        </li>
                        <li>
                            <a href="#section-3" class="hover:underline" style="color: #DB2077;">
                                3. Intellectual Property
                            </a>
                        </li>
                        <li>
                            <a href="#section-4" class="hover:underline" style="color: #DB2077;">
                                4. User Accounts
                            </a>
                        </li>
                        <li>
                            <a href="#section-5" class="hover:underline" style="color: #DB2077;">
                                5. Purchases & Payments
                            </a>
                        </li>
                        <li>
                            <a href="#section-7" class="hover:underline" style="color: #DB2077;">
                                6. Returns & Refunds
                            </a>
                        </li>
                        <li>
                            <a href="#section-8" class="hover:underline" style="color: #DB2077;">
                                7. User Content
                            </a>
                        </li>
                        <li>
                            <a href="#section-9" class="hover:underline" style="color: #DB2077;">
                                8. Disclaimer of Warranties
                            </a>
                        </li>
                        <li>
                            <a href="#section-10" class="hover:underline" style="color: #DB2077;">
                                9. Limitation of Liability
                            </a>
                        </li>
                        <li>
                            <a href="#section-11" class="hover:underline" style="color: #DB2077;">
                                10. Indemnification
                            </a>
                        </li>
                        <li>
                            <a href="#section-12" class="hover:underline" style="color: #DB2077;">
                                11. Governing Law
                            </a>
                        </li>
                        <li>
                            <a href="#section-13" class="hover:underline" style="color: #DB2077;">
                                12. Changes to Terms
                            </a>
                        </li>
                        <li>
                            <a href="#section-14" class="hover:underline" style="color: #DB2077;">
                                13. Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Terms Content -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 space-y-8">
                    <!-- Introduction -->
                    <div class="prose prose-lg max-w-none" style="color: #2d1b24;">
                        <p>
                            Welcome to <strong>Latocross Artelier</strong>. By using our website and services, you agree to comply with and be bound by the following terms and conditions. Please read them carefully before using our platform.
                        </p>
                        <p>
                            If you do not agree to these terms, please do not use our website or services.
                        </p>
                    </div>

                    <!-- Section 1 -->
                    <div id="section-1" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">1</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Acceptance of Terms
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                By accessing and using Latocross Artelier website, you accept and agree to be bound by these Terms & Conditions. If you are using our services on behalf of an organization, you represent that you have the authority to bind that organization to these terms.
                            </p>
                            <p>
                                We reserve the right to update or modify these terms at any time without prior notice. Your continued use of the website constitutes acceptance of any changes.
                            </p>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div id="section-2" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">2</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Use of Website
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>You agree to use our website only for lawful purposes and in accordance with these terms. You may not:</p>
                            <ul>
                                <li>Use the website in any way that violates applicable laws or regulations</li>
                                <li>Attempt to gain unauthorized access to any part of the website</li>
                                <li>Use the website to transmit any harmful or malicious code</li>
                                <li>Interfere with or disrupt the website or its servers</li>
                                <li>Impersonate any person or entity</li>
                                <li>Use any automated system to access the website</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div id="section-3" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">3</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Intellectual Property
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                All content on this website, including but not limited to text, images, graphics, logos, and software, is the property of Latocross Artelier or its content suppliers and is protected by copyright, trademark, and other intellectual property laws.
                            </p>
                            <p>
                                You may not reproduce, distribute, modify, create derivative works of, publicly display, or commercially exploit any content without our prior written permission.
                            </p>
                            <p>
                                The Latocross Artelier name, logo, and related marks are trademarks of Latocross Artelier. Unauthorized use of these marks is prohibited.
                            </p>
                        </div>
                    </div>

                    <!-- Section 4 -->
                    <div id="section-4" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">4</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                User Accounts
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                Some features of our website may require you to create an account. When creating an account, you agree to provide accurate and complete information. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
                            </p>
                            <p>
                                You agree to notify us immediately of any unauthorized use of your account. We reserve the right to suspend or terminate accounts that violate these terms.
                            </p>
                        </div>
                    </div>

                    <!-- Section 5 -->
                    <div id="section-5" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">5</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Purchases & Payments
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                All purchases made through our website are subject to product availability. We strive to ensure that all product descriptions, images, and prices are accurate, but errors may occur. We reserve the right to correct any errors and to update product information at any time.
                            </p>
                            <p>
                                Prices are listed in Nigerian Naira (₦) unless otherwise stated. We accept various payment methods as displayed on our checkout page. By placing an order, you agree to pay the listed price plus any applicable taxes and shipping fees.
                            </p>
                        </div>
                    </div>

                   

                    <!-- Section 7 -->
                    <div id="section-7" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">7</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Returns & Refunds
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                We offer a 14-day return policy on all artworks. If you are not completely satisfied with your purchase, you may return the artwork within 14 days of receipt for a full refund, subject to the following conditions:
                            </p>
                            <ul>
                                <li>The artwork must be returned in its original condition</li>
                                <li>The artwork must be in its original packaging</li>
                                <li>The buyer is responsible for return shipping costs</li>
                                <li>A Certificate of Authenticity must be included</li>
                            </ul>
                            <p>
                                Refunds will be processed within 7-10 business days after we receive the returned artwork. Custom or commissioned works are not eligible for return.
                            </p>
                        </div>
                    </div>

                    <!-- Section 8 -->
                    <div id="section-8" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">8</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                User Content
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                By submitting content to our website, including reviews, comments, or feedback, you grant us a non-exclusive, royalty-free, perpetual, and worldwide license to use, reproduce, modify, and distribute that content.
                            </p>
                            <p>
                                You represent that you own or have the rights to any content you submit and that the content does not infringe on the rights of any third party.
                            </p>
                            <p>
                                We reserve the right to remove any content that violates these terms or is otherwise inappropriate.
                            </p>
                        </div>
                    </div>

                    <!-- Section 9 -->
                    <div id="section-9" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">9</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Disclaimer of Warranties
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                The website and all content, products, and services are provided "as is" without warranties of any kind, whether express or implied. We do not warrant that:
                            </p>
                            <ul>
                                <li>The website will meet your requirements</li>
                                <li>The website will be uninterrupted, timely, or error-free</li>
                                <li>The results obtained from using the website will be accurate or reliable</li>
                                <li>The quality of any products or services will meet your expectations</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 10 -->
                    <div id="section-10" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">10</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Limitation of Liability
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                To the fullest extent permitted by law, Latocross Artelier shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to lost profits, data loss, or goodwill, arising from your use of our website or services.
                            </p>
                            <p>
                                Our total liability for any claim arising from these terms shall not exceed the amount you paid for the specific product or service in question.
                            </p>
                        </div>
                    </div>

                    <!-- Section 11 -->
                    <div id="section-11" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">11</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Indemnification
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                You agree to indemnify and hold Latocross Artelier and its affiliates, officers, directors, employees, and agents harmless from any claims, damages, losses, or expenses arising from:
                            </p>
                            <ul>
                                <li>Your use of the website or services</li>
                                <li>Your violation of these terms</li>
                                <li>Your violation of any third-party rights</li>
                                <li>Any content you submit to the website</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 12 -->
                    <div id="section-12" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">12</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Governing Law
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                These terms shall be governed by and construed in accordance with the laws of Nigeria. Any disputes arising from these terms shall be subject to the exclusive jurisdiction of the courts of Lagos, Nigeria.
                            </p>
                            <p>
                                If any provision of these terms is found to be invalid or unenforceable, the remaining provisions shall remain in full force and effect.
                            </p>
                        </div>
                    </div>

                    <!-- Section 13 -->
                    <div id="section-13" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">13</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Changes to Terms
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                We reserve the right to revise these terms at any time. When we do, we will update the "Last Updated" date at the top of this page. Your continued use of the website after changes are posted constitutes your acceptance of the revised terms.
                            </p>
                            <p>
                                We encourage you to review these terms periodically to stay informed of any updates.
                            </p>
                        </div>
                    </div>

                    <!-- Section 14 -->
                    <div id="section-14" class="terms-section-item">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">14</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Contact Us
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                If you have any questions, concerns, or requests regarding these Terms & Conditions, please contact us:
                            </p>
                            <div class="bg-gray-50 rounded-xl p-4 mt-2" style="background: #faf0f5;">
                                <p class="mb-1">
                                    <strong>Latocross Artelier</strong>
                                </p>
                                <p class="mb-1">
                                    <span style="color: #6b3b4f;">Email:</span> 
                                    <a href="mailto:info@latocross.com" style="color: #DB2077;">info@latocross.com</a>
                                </p>
                                <p class="mb-1">
                                    <span style="color: #6b3b4f;">Phone:</span> 
                                    <a href="tel:+2348000000000" style="color: #DB2077;">+234 800 000 0000</a>
                                </p>
                                <p>
                                    <span style="color: #6b3b4f;">Address:</span> 
                                    <span style="color: #1a0a0f;">Lagos, Nigeria</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back to Top -->
                <div class="text-center mt-8">
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-medium transition-all duration-300 hover:gap-3"
                       style="color: #DB2077;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        Back to Top
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .terms-section .prose {
            max-width: none;
        }

        .terms-section .prose h1,
        .terms-section .prose h2,
        .terms-section .prose h3,
        .terms-section .prose h4 {
            color: #1a0a0f;
            font-family: 'Georgia', serif;
        }

        .terms-section .prose p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .terms-section .prose ul {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .terms-section .prose li {
            margin-bottom: 0.5rem;
        }

        .terms-section .prose strong {
            color: #1a0a0f;
        }

        .terms-section .prose a {
            color: #DB2077;
            text-decoration: underline;
        }

        .terms-section .prose a:hover {
            opacity: 0.8;
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Section hover effect */
        .terms-section-item:hover .w-10 {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }

            .terms-section {
                padding: 2rem 1rem;
            }

            .terms-section .bg-white {
                padding: 1.5rem;
            }

            .terms-section-item .prose {
                padding-left: 0 !important;
            }

            .terms-section-item .flex.items-center.gap-3 {
                padding-left: 0;
            }
        }

        @media (max-width: 640px) {
            .terms-section .grid.md\:grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .terms-section .text-xl {
                font-size: 1.125rem;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }

            .terms-section .bg-white {
                box-shadow: none !important;
                border: 1px solid #e5d0d8;
            }

            .terms-section .bg-gray-50 {
                background: #faf0f5 !important;
            }

            .terms-section-item .w-10 {
                background: #fce4ec !important;
            }

            a[href]::after {
                content: " (" attr(href) ")";
                font-size: 0.8em;
                color: #6b3b4f;
            }
        }

        /* Focus styles */
        a:focus-visible {
            outline: 2px solid #DB2077;
            outline-offset: 2px;
            border-radius: 4px;
        }
    </style>
@endsection