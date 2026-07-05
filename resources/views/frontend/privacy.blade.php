@extends('layouts.app')

@section('title', 'Privacy Policy - Latoecross Artelier')
@section('meta_description', 'Read our privacy policy to understand how Latocross Artelier collects, uses, and protects your personal information.')

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
                            <span class="text-white font-medium">Privacy Policy</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" style="font-family: 'Georgia', serif;">
                    Privacy Policy
                </h1>
                <p class="text-pink-200 text-base md:text-lg max-w-2xl mx-auto">
                    Your privacy matters to us. Learn how we collect, use, and protect your personal information.
                </p>
                <div class="mt-4 text-sm text-pink-300">
                    Last Updated: {{ date('F j, Y') }}
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Policy Content -->
    <section class="privacy-policy-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
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
                                1. Information We Collect
                            </a>
                        </li>
                        <li>
                            <a href="#section-2" class="hover:underline" style="color: #DB2077;">
                                2. How We Use Your Information
                            </a>
                        </li>
                        <li>
                            <a href="#section-3" class="hover:underline" style="color: #DB2077;">
                                3. Information Sharing
                            </a>
                        </li>
                        <li>
                            <a href="#section-4" class="hover:underline" style="color: #DB2077;">
                                4. Data Security
                            </a>
                        </li>
                        <li>
                            <a href="#section-5" class="hover:underline" style="color: #DB2077;">
                                5. Your Rights
                            </a>
                        </li>
                        <li>
                            <a href="#section-6" class="hover:underline" style="color: #DB2077;">
                                6. Cookies
                            </a>
                        </li>
                        <li>
                            <a href="#section-7" class="hover:underline" style="color: #DB2077;">
                                7. Third-Party Links
                            </a>
                        </li>
                        <li>
                            <a href="#section-8" class="hover:underline" style="color: #DB2077;">
                                8. Children's Privacy
                            </a>
                        </li>
                        <li>
                            <a href="#section-9" class="hover:underline" style="color: #DB2077;">
                                9. Changes to This Policy
                            </a>
                        </li>
                        <li>
                            <a href="#section-10" class="hover:underline" style="color: #DB2077;">
                                10. Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Privacy Content -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 space-y-8">
                    <!-- Introduction -->
                    <div class="prose prose-lg max-w-none" style="color: #2d1b24;">
                        <p>
                            At <strong>Latocross Artelier</strong>, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.
                        </p>
                        <p>
                            By using our website, you consent to the practices described in this policy. If you do not agree with this policy, please do not use our website or services.
                        </p>
                    </div>

                    <!-- Section 1 -->
                    <div id="section-1" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">1</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Information We Collect
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>We may collect the following types of information:</p>
                            <ul>
                                <li>
                                    <strong>Personal Information:</strong> Name, email address, phone number, shipping address, and payment information when you make a purchase or enquiry.
                                </li>
                                <li>
                                    <strong>Usage Data:</strong> Information about how you interact with our website, including pages visited, time spent, and links clicked.
                                </li>
                                <li>
                                    <strong>Device Information:</strong> IP address, browser type, operating system, and device identifiers.
                                </li>
                                <li>
                                    <strong>Cookies:</strong> Small data files stored on your device to enhance your browsing experience.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div id="section-2" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">2</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                How We Use Your Information
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>We use your information for the following purposes:</p>
                            <ul>
                                <li>To process and fulfill your orders and enquiries</li>
                                <li>To communicate with you about your purchases, enquiries, and account</li>
                                <li>To send you marketing communications (with your consent)</li>
                                <li>To improve our website, products, and services</li>
                                <li>To detect and prevent fraud and security incidents</li>
                                <li>To comply with legal obligations</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div id="section-3" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">3</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Information Sharing
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>We do not sell, trade, or rent your personal information to third parties. We may share your information in the following circumstances:</p>
                            <ul>
                                <li>
                                    <strong>Service Providers:</strong> We may share your information with trusted third-party service providers who assist us in operating our website, processing payments, and delivering orders.
                                </li>
                                <li>
                                    <strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to valid legal requests.
                                </li>
                                <li>
                                    <strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred to the new owner.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 4 -->
                    <div id="section-4" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">4</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Data Security
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
                            <ul>
                                <li>SSL/TLS encryption for all data transmission</li>
                                <li>Secure storage of sensitive information</li>
                                <li>Regular security assessments and updates</li>
                                <li>Access controls and authentication mechanisms</li>
                            </ul>
                            <p>
                                While we strive to protect your information, no method of transmission over the internet or electronic storage is 100% secure. We cannot guarantee absolute security.
                            </p>
                        </div>
                    </div>

                    <!-- Section 5 -->
                    <div id="section-5" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">5</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Your Rights
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>You have the following rights regarding your personal information:</p>
                            <ul>
                                <li>
                                    <strong>Access:</strong> You can request a copy of the personal information we hold about you.
                                </li>
                                <li>
                                    <strong>Correction:</strong> You can request that we correct any inaccurate or incomplete information.
                                </li>
                                <li>
                                    <strong>Deletion:</strong> You can request that we delete your personal information, subject to certain exceptions.
                                </li>
                                <li>
                                    <strong>Restriction:</strong> You can request that we restrict the processing of your information.
                                </li>
                                <li>
                                    <strong>Data Portability:</strong> You can request a copy of your information in a structured, machine-readable format.
                                </li>
                            </ul>
                            <p>
                                To exercise any of these rights, please <a href="{{ route('contact') }}" style="color: #DB2077;">contact us</a>.
                            </p>
                        </div>
                    </div>

                    <!-- Section 6 -->
                    <div id="section-6" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">6</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Cookies
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                We use cookies and similar tracking technologies to enhance your browsing experience, analyze website traffic, and personalize content. Cookies are small text files stored on your device.
                            </p>
                            <p>
                                You can control cookie preferences through your browser settings. You may choose to disable cookies, but this may affect the functionality of our website.
                            </p>
                            <p>
                                We use the following types of cookies:
                            </p>
                            <ul>
                                <li><strong>Essential Cookies:</strong> Necessary for basic website functionality</li>
                                <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our website</li>
                                <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section 7 -->
                    <div id="section-7" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">7</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Third-Party Links
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review the privacy policies of any third-party websites you visit.
                            </p>
                        </div>
                    </div>

                    <!-- Section 8 -->
                    <div id="section-8" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">8</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Children's Privacy
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                Our services are not directed to children under the age of 13. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please <a href="{{ route('contact') }}" style="color: #DB2077;">contact us</a> immediately.
                            </p>
                        </div>
                    </div>

                    <!-- Section 9 -->
                    <div id="section-9" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">9</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Changes to This Policy
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page with an updated date. We encourage you to review this policy periodically.
                            </p>
                        </div>
                    </div>

                    <!-- Section 10 -->
                    <div id="section-10" class="privacy-section">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: #fce4ec;">
                                <span class="font-bold" style="color: #DB2077;">10</span>
                            </div>
                            <h3 class="text-xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Contact Us
                            </h3>
                        </div>
                        <div class="prose prose-lg max-w-none" style="color: #2d1b24; padding-left: 3.25rem;">
                            <p>
                                If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us:
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
        .privacy-policy-section .prose {
            max-width: none;
        }

        .privacy-policy-section .prose h1,
        .privacy-policy-section .prose h2,
        .privacy-policy-section .prose h3,
        .privacy-policy-section .prose h4 {
            color: #1a0a0f;
            font-family: 'Georgia', serif;
        }

        .privacy-policy-section .prose p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .privacy-policy-section .prose ul {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .privacy-policy-section .prose li {
            margin-bottom: 0.5rem;
        }

        .privacy-policy-section .prose strong {
            color: #1a0a0f;
        }

        .privacy-policy-section .prose a {
            color: #DB2077;
            text-decoration: underline;
        }

        .privacy-policy-section .prose a:hover {
            opacity: 0.8;
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Section hover effect */
        .privacy-section:hover .w-10 {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb-section {
                padding: 3rem 1rem;
            }

            .privacy-policy-section {
                padding: 2rem 1rem;
            }

            .privacy-policy-section .bg-white {
                padding: 1.5rem;
            }

            .privacy-section .prose {
                padding-left: 0 !important;
            }

            .privacy-section .flex.items-center.gap-3 {
                padding-left: 0;
            }
        }

        @media (max-width: 640px) {
            .privacy-policy-section .grid.md\:grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .privacy-policy-section .text-xl {
                font-size: 1.125rem;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }

            .privacy-policy-section .bg-white {
                box-shadow: none !important;
                border: 1px solid #e5d0d8;
            }

            .privacy-policy-section .bg-gray-50 {
                background: #faf0f5 !important;
            }

            .privacy-section .w-10 {
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