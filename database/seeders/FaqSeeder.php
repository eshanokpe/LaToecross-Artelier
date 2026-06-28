<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What types of art do you offer?',
                'answer' => 'We offer a diverse collection of contemporary African art including abstract paintings, landscape paintings, mixed media, figure paintings, and miniature artworks. Our collection spans various styles and mediums.',
                'category' => 'General',
                'sort_order' => 1,
            ],
            [
                'question' => 'How do I purchase an artwork?',
                'answer' => 'To purchase an artwork, browse our collection, click on the artwork you\'re interested in, and use the "Make Enquiry" button. Our team will contact you with purchase details and guide you through the process.',
                'category' => 'Purchasing',
                'sort_order' => 1,
            ],
            [
                'question' => 'Do you ship internationally?',
                'answer' => 'Yes, we offer worldwide shipping. Shipping costs and delivery times vary depending on the destination and the size of the artwork. We ensure all artworks are securely packaged and insured during transit.',
                'category' => 'Shipping',
                'sort_order' => 1,
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'We offer a 14-day return policy on all artworks. If you\'re not completely satisfied with your purchase, please contact us within 14 days of receiving the artwork to arrange a return. Terms and conditions apply.',
                'category' => 'Returns',
                'sort_order' => 1,
            ],
            [
                'question' => 'How do I know if an artwork is authentic?',
                'answer' => 'All artworks come with a Certificate of Authenticity (COA) issued by the artist or our gallery. We work directly with artists and reputable galleries to ensure every piece is genuine and authenticated.',
                'category' => 'Authenticity',
                'sort_order' => 1,
            ],
            [
                'question' => 'Can I commission a custom artwork?',
                'answer' => 'Yes, we work with a network of talented artists who can create custom pieces based on your preferences. Contact us with your requirements and we\'ll connect you with the right artist for your project.',
                'category' => 'Custom Orders',
                'sort_order' => 1,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept various payment methods including bank transfers, credit/debit cards, and secure online payment gateways. Payment details will be provided during the purchase process.',
                'category' => 'Payments',
                'sort_order' => 1,
            ],
            [
                'question' => 'How long does delivery take?',
                'answer' => 'Delivery times vary depending on your location. For local deliveries (Nigeria), it typically takes 3-5 business days. International deliveries usually take 7-14 business days depending on customs clearance.',
                'category' => 'Shipping',
                'sort_order' => 2,
            ],
            [
                'question' => 'Do you offer framing services?',
                'answer' => 'Yes, we offer professional framing services for all artworks. Our team can advise on the best framing options to complement your artwork and space. Framing costs are additional and vary based on the artwork size and frame type.',
                'category' => 'Services',
                'sort_order' => 1,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}