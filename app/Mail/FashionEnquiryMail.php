<?php

namespace App\Mail;

use App\Models\Fashion;
use App\Models\FashionEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FashionEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public FashionEnquiry $enquiry;
    public Fashion $fashion;

    public function __construct(FashionEnquiry $enquiry, Fashion $fashion)
    {
        $this->enquiry = $enquiry;
        $this->fashion = $fashion;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Fashion Enquiry: ' . $this->fashion->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.fashion-enquiry',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}