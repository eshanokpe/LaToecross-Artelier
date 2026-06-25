<?php

use App\Models\ContactMessage;
use App\Models\Setting;
use Livewire\Component;

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

    public function mount(): void
    {
        $this->phone         = Setting::get('phone');
        $this->phone2        = Setting::get('phone2');
        $this->contactEmail  = Setting::get('email');
        $this->contactEmail2 = Setting::get('email2');
        $this->address       = Setting::get('address');
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

        ContactMessage::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_read' => false,
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);

        session()->flash('contact_success', 'Your message has been sent successfully. We will get back to you soon.');
    }
};
?>

<div>
    <!-- contact page section starts here -->
    <div class="contact-page mb-120">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-5">
                    <div class="map-area">
                        <h3>Contact Us by Phone</h3>
                        <div class="single-content">
                            <ul>
                                @if ($phone)
                                    <li>
                                        Phone : <a href="tel:{{ $phone }}">{{ $phone }}</a>
                                    </li>
                                @endif
                                @if ($phone2)
                                    <li>
                                        Phone 2 : <a href="tel:{{ $phone2 }}">{{ $phone2 }}</a>
                                    </li>
                                @endif
                                @if ($contactEmail)
                                    <li>
                                        Email : <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                    </li>
                                @endif
                                @if ($contactEmail2)
                                    <li>
                                        Email 2 : <a href="mailto:{{ $contactEmail2 }}">{{ $contactEmail2 }}</a>
                                    </li>
                                @endif
                                @if ($address)
                                    <li>
                                        Address : {{ $address }}
                                    </li>
                                @endif
                            </ul>
                            <ul class="opening-time">
                                <li>
                                    at - <span>9:30 am - 6:30 pm</span>
                                </li>
                                <li>
                                    from - <span>Monday to Friday</span>
                                </li>
                            </ul>
                        </div>
                        <div class="contact-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.564763185785!2d90.36311167608078!3d23.834071185557615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c14c8682a473%3A0xa6c74743d52adb88!2sEgens%20Lab!5e0!3m2!1sen!2sbd!4v1685535738307!5m2!1sen!2sbd" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="enquery-section style-2 ">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mb-25">
                                    <div class="enquery-section-title">
                                        <h3>Contact Us by Email</h3>
                                        <p>Have a question about a piece or need help with an order? Send us a message and our team will get back to you shortly.</p>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="enquery-form-wrapper">
                                        @if (session('contact_success'))
                                            <div class="alert alert-success mb-30" role="alert">
                                                {{ session('contact_success') }}
                                            </div>
                                        @endif

                                        <form wire:submit="submit">
                                            <div class="row">
                                                <div class="col-md-6 mb-30">
                                                    <div class="form-inner3">
                                                        <label>first name *</label>
                                                        <input type="text" wire:model="name" placeholder="Mr. Harry">
                                                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-30">
                                                    <div class="form-inner3">
                                                        <label>email address *</label>
                                                        <input type="email" wire:model="email" placeholder="info@example.com">
                                                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-30">
                                                    <div class="form-inner3">
                                                        <label>subject</label>
                                                        <input type="text" wire:model="subject" placeholder="Subject (optional)">
                                                        @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-40">
                                                    <div class="form-inner3">
                                                        <label>message</label>
                                                        <textarea wire:model="message" placeholder="Write your message"></textarea>
                                                        @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="form-inner3">
                                                        <button type="submit" class="primary-btn1 btn-hover" wire:loading.attr="disabled" wire:target="submit">
                                                            <span wire:loading.remove wire:target="submit">Submit Here</span>
                                                            <span wire:loading wire:target="submit">Sending...</span>
                                                            <strong></strong>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact page section ends here -->
</div>