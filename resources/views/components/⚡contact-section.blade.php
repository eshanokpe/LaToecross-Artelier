<?php

use App\Models\ContactMessage;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\ContactFormAutoReplyMail;

new class extends Component 
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public ?string $phone = null;
    public ?string $phone2 = null;
    public ?string $contactEmail = null;
    public ?string $contactEmail2 = null;
    public ?string $address = null;
    public ?string $whatsapp = null;
    public ?string $facebook_url = null;
    public ?string $instagram_url = null;
    public ?string $tiktok_url = null;

    public function mount(): void
    {
        $this->phone         = Setting::get('phone');
        $this->phone2        = Setting::get('phone2');
        $this->contactEmail  = Setting::get('email');
        $this->contactEmail2 = Setting::get('email2');
        $this->address       = Setting::get('address');
        $this->whatsapp      = Setting::get('whatsapp');
        $this->facebook_url  = Setting::get('facebook');
        $this->instagram_url = Setting::get('instagram');
        $this->tiktok_url    = Setting::get('tiktok');
    }

    protected function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        // Save to database
        $contact = ContactMessage::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_read' => false,
        ]);

        // ✅ Send email notification
        try { 
            
            $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
            Mail::to($recipients)
                ->send(new ContactFormMail($this->name, $this->email, $this->subject, $this->message));
            
            // Optional: Send auto-reply to user
            Mail::to($this->email)
                ->send(new ContactFormAutoReplyMail($this->name));
            
        } catch (\Exception $e) {
            // Log error but don't fail the submission
            \Log::error('Contact email failed: ' . $e->getMessage());
            session()->flash('contact_warning', 'Your message was saved but email notification failed. We will still get back to you.');
        }

        $this->reset(['name', 'email', 'subject', 'message']);

        session()->flash('contact_success', 'Your message has been sent successfully. We will get back to you soon.');
    }
};
?>

<div class="contact-section-wrapper">
    <!-- Contact Section -->
    <section class="contact-section py-16 md:py-20" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        Get In Touch
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-4" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        Let's Connect
                    </h2>
                    <p class="text-lg mt-3 max-w-2xl mx-auto" style="color: #6b3b4f;">
                        Have a question about a piece, need assistance, or want to collaborate? We'd love to hear from you.
                    </p>
                    <div class="w-24 h-1 mx-auto mt-6 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid lg:grid-cols-5 gap-8">
                    <!-- Contact Information Column -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Contact Info Cards -->
                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6" style="border-left: 4px solid #DB2077;">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold" style="color: #1a0a0f;">Call Us</h4>
                                        @if ($phone)
                                            <a href="tel:{{ $phone }}" class="text-sm hover:underline" style="color: #6b3b4f;">{{ $phone }}</a>
                                        @endif
                                        @if ($phone2)
                                            <a href="tel:{{ $phone2 }}" class="text-sm hover:underline block" style="color: #6b3b4f;">{{ $phone2 }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6" style="border-left: 4px solid #ff6b9d;">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #ff6b9d, #ff9ec4);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold" style="color: #1a0a0f;">Email Us</h4>
                                        @if ($contactEmail)
                                            <a href="mailto:{{ $contactEmail }}" class="text-sm hover:underline" style="color: #6b3b4f;">{{ $contactEmail }}</a>
                                        @endif
                                        @if ($contactEmail2)
                                            <a href="mailto:{{ $contactEmail2 }}" class="text-sm hover:underline block" style="color: #6b3b4f;">{{ $contactEmail2 }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6" style="border-left: 4px solid #ff9ec4;">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #ff9ec4, #ffc1dc);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold" style="color: #1a0a0f;">Visit Us</h4>
                                        @if ($address)
                                            <p class="text-sm" style="color: #6b3b4f;">{{ $address }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($whatsapp)
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6" style="border-left: 4px solid #25D366;">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #25D366;">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold" style="color: #1a0a0f;">WhatsApp</h4>
                                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="text-sm hover:underline" style="color: #25D366;">Chat with us on WhatsApp</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Opening Hours -->
                            <div class="bg-white rounded-2xl shadow-lg p-6" style="border-left: 4px solid #DB2077;">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold" style="color: #1a0a0f;">Opening Hours</h4>
                                        <p class="text-sm" style="color: #6b3b4f;">
                                            <span class="font-medium">Monday - Friday:</span> 9:30 AM - 6:30 PM<br>
                                            <span class="font-medium">Saturday:</span> 10:00 AM - 4:00 PM<br>
                                            <span class="font-medium">Sunday:</span> Closed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form Column -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 lg:p-10">
                            <!-- Success Message -->
                            @if (session('contact_success'))
                                <div class="mb-6 p-4 rounded-xl flex items-start gap-3" style="background: #f0fdf4; border: 1px solid #86efac;">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium" style="color: #166534;">Success!</p>
                                        <p class="text-sm" style="color: #15803d;">{{ session('contact_success') }}</p>
                                        <p class="text-xs mt-1" style="color: #15803d;">A confirmation email has been sent to your inbox.</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('contact_warning'))
                                <div class="mb-6 p-4 rounded-xl flex items-start gap-3" style="background: #fefce8; border: 1px solid #fde68a;">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium" style="color: #92400e;">⚠️ Warning</p>
                                        <p class="text-sm" style="color: #78350f;">{{ session('contact_warning') }}</p>
                                    </div>
                                </div>
                            @endif

                            <h3 class="text-2xl font-bold mb-2" style="color: #1a0a0f; font-family: 'Georgia', serif;">Send Us a Message</h3>
                            <p class="text-sm mb-6" style="color: #6b3b4f;">Fill in the form below and we'll get back to you as soon as possible.</p>

                            <form wire:submit="submit" class="space-y-5">
                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                            Full Name <span style="color: #DB2077;">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            wire:model="name" 
                                            placeholder="Enter your full name"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                            style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;"
                                            wire:focus="border-color: #DB2077; ring-color: #DB2077;"
                                        >
                                        @error('name') 
                                            <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                            Email Address <span style="color: #DB2077;">*</span>
                                        </label>
                                        <input 
                                            type="email" 
                                            wire:model="email" 
                                            placeholder="Enter your email"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                            style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;"
                                        >
                                        @error('email') 
                                            <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                        Subject <span style="color: #6b3b4f;">(optional)</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="subject" 
                                        placeholder="What is this regarding?"
                                        class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                        style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;"
                                    >
                                    @error('subject') 
                                        <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                        Message <span style="color: #DB2077;">*</span>
                                    </label>
                                    <textarea 
                                        wire:model="message" 
                                        rows="5"
                                        placeholder="Tell us how we can help you..."
                                        class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 resize-y"
                                        style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f; min-height: 120px;"
                                    ></textarea>
                                    @error('message') 
                                        <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                                    @enderror
                                    <div class="text-xs mt-1 text-right" style="color: #6b3b4f;">
                                        <span wire:model="message" x-text="$wire.message.length"></span>/2000 characters
                                    </div>
                                </div>

                                <button 
                                    type="submit" 
                                    class="w-full md:w-auto px-8 py-3.5 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-2"
                                    style="background: linear-gradient(135deg, #DB2077, #ff6b9d);"
                                    wire:loading.attr="disabled" 
                                    wire:target="submit"
                                >
                                    <span wire:loading.remove wire:target="submit">
                                        Send Message
                                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="submit">
                                        <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Sending...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section py-8" style="background: #1a0a0f;">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-2xl overflow-hidden shadow-2xl" style="border: 3px solid #DB2077;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.564763185785!2d90.36311167608078!3d23.834071185557615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c14c8682a473%3A0xa6c74743d52adb88!2sEgens%20Lab!5e0!3m2!1sen!2sbd!4v1685535738307!5m2!1sen!2sbd" 
                        style="border:0; width: 100%; height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Latocross Artelier Location Map"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Contact CTA with Social Icons -->
    <section class="quick-cta py-12" style="background: linear-gradient(135deg, #faf0f5, #fce4ec);">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-2xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">Prefer to Connect on Social Media?</h3>
                <p class="text-sm mt-2" style="color: #6b3b4f;">Follow us for daily art inspiration, behind-the-scenes content, and exclusive updates.</p>
                <div class="flex justify-center gap-4 mt-6">
                    <!-- Facebook -->
                    @if($facebook_url)
                        <a href="{{ $facebook_url }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: #1877F2; color: white;">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    @endif

                    <!-- Instagram -->
                    @if($instagram_url)
                        <a href="{{ $instagram_url }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white;">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    @endif

                    <!-- TikTok -->
                    @if($tiktok_url)
                        <a href="{{ $tiktok_url }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg" style="background: #000000; color: white;">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.11-.59-1.62-.93-.01 2.92.01 5.84-.02 8.76-.08 1.4-.54 2.79-1.35 3.99-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .contact-section-wrapper {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Focus styles for form inputs */
        input:focus, textarea:focus {
            border-color: #DB2077 !important;
            ring-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #fce4ec;
            border-radius: 10px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #DB2077;
            border-radius: 10px;
        }

        /* Button hover animation */
        button:hover {
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0px);
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contact-section {
                padding: 3rem 1rem;
            }

            .map-section iframe {
                height: 250px;
            }
        }

        @media (max-width: 640px) {
            .contact-section .grid {
                gap: 1.5rem;
            }
        }

        /* Print styles */
        @media print {
            .quick-cta {
                display: none;
            }
        }
    </style>
</div>