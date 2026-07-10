<?php

use Livewire\Component;
use App\Models\Artwork;
use App\Models\ArtworkEnquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ArtworkEnquiryMail;
use UltraMsg\WhatsAppApi;

new class extends Component
{
    public Artwork $artwork;
    public $relatedArtworks = [];
    
    // Enquiry Form Properties
    public $enquiryName = '';
    public $enquiryEmail = '';
    public $enquiryPhone = '';
    public $enquiryMessage = '';
    public $showEnquiryModal = false;
    
    protected $rules = [
        'enquiryName' => 'required|string|max:255',
        'enquiryEmail' => 'required|email|max:255',
        'enquiryPhone' => 'nullable|string|max:20',
        'enquiryMessage' => 'required|string|min:10|max:2000',
    ];
    
    public function mount(Artwork $artwork)
    {
        $this->artwork = $artwork;
        $this->loadRelatedArtworks();
    }
    
    public function loadRelatedArtworks()
    {
        $this->relatedArtworks = Artwork::where('id', '!=', $this->artwork->id)
            ->where('style', $this->artwork->style)
            ->take(4)
            ->get();
    }
    
    public function openEnquiryModal()
    {
        $this->showEnquiryModal = true;
        $this->resetValidation();
    }
    
    public function closeEnquiryModal()
    {
        $this->showEnquiryModal = false;
        $this->reset(['enquiryName', 'enquiryEmail', 'enquiryPhone', 'enquiryMessage']);
        $this->resetValidation();
    }
    
    public function submitEnquiry()
    {
        $this->validate();
        
        // Save enquiry to database
        $enquiry = ArtworkEnquiry::create([
            'artwork_id' => $this->artwork->id,
            'name' => $this->enquiryName,
            'email' => $this->enquiryEmail,
            'phone' => $this->enquiryPhone,
            'message' => $this->enquiryMessage,
            'is_read' => false,
        ]);
        
        $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
        Mail::to($recipients)->send(new ArtworkEnquiryMail($enquiry, $this->artwork));
 
        // WhatsApp notification 
        try {
            $instanceId = trim(env('ULTRAMSG_INSTANCE_ID', ''));
            $token      = trim(env('ULTRAMSG_TOKEN', ''));
            $adminPhone = trim(env('ULTRAMSG_ADMIN_NUMBER', ''));

            if (empty($instanceId) || empty($token) || empty($adminPhone)) {
                Log::error('UltraMsg credentials missing in .env');
                session()->flash('enquiry_warning', 'Enquiry saved, WhatsApp config incomplete.');
            } else {
                $api = new WhatsAppApi($token, $instanceId);

                $status = $api->getInstanceStatus();
                Log::info('UltraMsg Instance Status:', (array) $status);

                $accountStatus = data_get($status, 'status.accountStatus.status');

                if ($accountStatus === 'authenticated') {
                    $whatsappMessage = "🎨 *New Artwork Enquiry*\n\n"
                        . "🖼️ *Artwork:* {$this->artwork->title}\n"
                        . "👤 *Name:* {$this->enquiryName}\n"
                        . "📧 *Email:* {$this->enquiryEmail}\n"
                        . "📞 *Phone:* " . ($this->enquiryPhone ?: 'Not provided') . "\n\n"
                        . "💬 *Message:*\n{$this->enquiryMessage}";

                    $response = $api->sendChatMessage($adminPhone, $whatsappMessage);
                    Log::info('UltraMsg Send Response:', (array) $response);
                } else {
                    Log::warning('UltraMsg not ready:', (array) $status);
                    session()->flash('enquiry_warning', 'Enquiry saved, WhatsApp alert failed.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Artwork Enquiry WhatsApp Error: ' . $e->getMessage());
            session()->flash('enquiry_warning', 'Enquiry saved, but WhatsApp notification failed.');
        }
        
        // Success message
        session()->flash('enquiry_success', 'Your enquiry has been sent successfully. We will get back to you shortly.');
        
        // Close modal and reset form
        $this->closeEnquiryModal();
        
        // Dispatch event for notification
        $this->dispatch('enquiry-sent');
    }
};
?>

<div class="artwork-details-wrapper">
    <!-- Artwork Details Section -->
    <section class="artwork-details-section py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Image Gallery Column -->
                    <div class="space-y-4">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-white">
                            <!-- Main Image -->
                            <div class="relative">
                                <img 
                                    src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                    alt="{{ $this->artwork->title }}"
                                    class="w-full h-auto object-cover"
                                    style="max-height: 600px;"
                                    loading="lazy"
                                >
                                
                                <!-- Status Badge -->
                                @if($this->artwork->is_for_sale)
                                    <span class="absolute top-4 left-4 px-4 py-1.5 text-xs font-bold rounded-full uppercase tracking-wider" 
                                          style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; box-shadow: 0 4px 15px rgba(219, 32, 119, 0.3);">
                                        Available for Enquiry
                                    </span>
                                @else
                                    <span class="absolute top-4 left-4 px-4 py-1.5 text-xs font-bold rounded-full uppercase tracking-wider" 
                                          style="background: #1a0a0f; color: white; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                                        Sold Out
                                    </span>
                                @endif
                                
                            </div>
                            
                            <!-- Image Controls -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-3">
                                <button class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" 
                                        style="background: rgba(255, 255, 255, 0.9); color: #DB2077; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110" 
                                        style="background: rgba(255, 255, 255, 0.9); color: #DB2077; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        <div class="grid grid-cols-4 gap-3">
                            <div class="relative rounded-xl overflow-hidden cursor-pointer hover:ring-2 transition-all duration-300" 
                                 style="border: 2px solid #DB2077; ring-color: #DB2077;">
                                <img src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                     alt="Thumbnail 1" 
                                     class="w-full h-20 object-cover">
                            </div>
                            <div class="relative rounded-xl overflow-hidden cursor-pointer hover:ring-2 transition-all duration-300 opacity-60 hover:opacity-100" 
                                 style="border: 2px solid transparent;">
                                <img src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                     alt="Thumbnail 2" 
                                     class="w-full h-20 object-cover">
                            </div>
                            <div class="relative rounded-xl overflow-hidden cursor-pointer hover:ring-2 transition-all duration-300 opacity-60 hover:opacity-100" 
                                 style="border: 2px solid transparent;">
                                <img src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                     alt="Thumbnail 3" 
                                     class="w-full h-20 object-cover">
                            </div>
                            <div class="relative rounded-xl overflow-hidden cursor-pointer hover:ring-2 transition-all duration-300 opacity-60 hover:opacity-100" 
                                 style="border: 2px solid transparent;">
                                <img src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                     alt="Thumbnail 4" 
                                     class="w-full h-20 object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Artwork Information Column -->
                    <div class="space-y-6">
                        <div>
                            
                            <h2 class="text-3xl md:text-4xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                {{ $this->artwork->title }}
                            </h2>
                        </div>

                        <!-- Artist & Price Info -->
                        <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl" style="background: #fce4ec;">
                            <div>
                                <p class="text-sm" style="color: #6b3b4f;">Category</p>
                                <p class="font-semibold" style="color: #1a0a0f;">
                                    {{ ucfirst(str_replace('_', ' ', $this->artwork->style)) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm" style="color: #6b3b4f;">Price</p>
                                <p class="font-bold text-xl" style="color: #DB2077;">
                                    @if($this->artwork->is_for_sale && $this->artwork->price)
                                        ₦{{ number_format($this->artwork->price, 2) }}
                                    @else
                                        <span style="color: #6b3b4f;">Not for sale</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h4 class="text-lg font-bold mb-2" style="color: #1a0a0f;">Description</h4>
                            <p class="text-gray-700 leading-relaxed" style="color: #2d1b24;">
                                {!! $this->artwork->description ?? 'No description available for this artwork.' !!}
                            </p>
                        </div>

                        <!-- Artwork Details -->
                        <div class="grid grid-cols-2 gap-4">
                            @if($this->artwork->medium)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Medium</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $this->artwork->medium }}</p>
                                </div>
                            @endif
                            @if($this->artwork->dimensions)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Dimensions</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $this->artwork->dimensions }}</p>
                                </div>
                            @endif
                        </div>
                        <!-- Success Message -->
                        @if (session('enquiry_success'))
                            <div class="mb-6 p-4 rounded-xl flex items-start gap-3" style="background: #f0fdf4; border: 1px solid #86efac;">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium" style="color: #166534;">Success!</p>
                                    <p class="text-sm" style="color: #15803d;">{{ session('enquiry_success') }}</p>
                                </div>
                            </div>
                        @endif
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 pt-2">
                            
                            
                            <button wire:click="openEnquiryModal" 
                                    class="flex-1 min-w-[140px] text-center px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105"
                                    style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                <span>Make Enquiry</span>
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </button>
                      
                        </div>


                        <!-- Ask Question -->
                        <div class="text-center pt-2">
                            <span class="text-sm" style="color: #6b3b4f;">
                                Have any questions? 
                                <a href="{{ route('contact') }}" class="font-semibold hover:underline" style="color: #DB2077;">
                                    Ask Us
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Artwork Details & Artist Info -->
    <section class="artwork-details-info py-12 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                        Artwork Details
                    </span>
                    <h3 class="text-2xl md:text-3xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                        About This Piece
                    </h3>
                    <div class="w-24 h-1 mx-auto mt-4 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Artist Overview -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-2xl transition-all duration-300" style="border-left: 4px solid #DB2077;">
                        <h5 class="text-xl font-bold mb-4" style="color: #1a0a0f; font-family: 'Georgia', serif;">Artist Overview</h5>
                        <ul class="space-y-4">
                            <li>
                                <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Category</h6>
                                <p style="color: #1a0a0f;">{{ ucfirst(str_replace('_', ' ', $this->artwork->style)) }}</p>
                            </li>
                            @if($this->artwork->medium)
                                <li>
                                    <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Medium</h6>
                                    <p style="color: #1a0a0f;">{{ $this->artwork->medium }}</p>
                                </li>
                            @endif
                            @if($this->artwork->dimensions)
                                <li>
                                    <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Dimensions</h6>
                                    <p style="color: #1a0a0f;">{{ $this->artwork->dimensions }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Artwork Specifications -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-2xl transition-all duration-300" style="border-left: 4px solid #ff6b9d;">
                        <h5 class="text-xl font-bold mb-4" style="color: #1a0a0f; font-family: 'Georgia', serif;">Exploring the Artwork</h5>
                        <ul class="space-y-4">
                            <li>
                                <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Price</h6>
                                <p style="color: #1a0a0f;">
                                    @if($this->artwork->is_for_sale && $this->artwork->price)
                                        ₦{{ number_format($this->artwork->price, 2) }}
                                    @else
                                        Not for sale
                                    @endif
                                </p>
                            </li>
                            <li>
                                <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Availability</h6>
                                <p style="color: #1a0a0f;">
                                    @if($this->artwork->is_for_sale)
                                        <span style="color: #22c55e;">Available for Enquiry</span>
                                    @else
                                        <span style="color: #6b3b4f;">Sold Out</span>
                                    @endif
                                </p>
                            </li>
                            <li>
                                <h6 class="font-semibold text-sm" style="color: #6b3b4f;">Featured</h6>
                                <p style="color: #1a0a0f;">
                                    @if($this->artwork->is_featured)
                                        <span style="color: #DB2077;">★ Featured Artwork</span>
                                    @else
                                        Standard
                                    @endif
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Artworks Section -->
    @if($this->relatedArtworks->count() > 0)
        <section class="related-artworks py-12 md:py-16" style="background: #faf0f5;">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                        <div>
                            <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                                You May Also Like
                            </span>
                            <h3 class="text-2xl md:text-3xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                Related Artworks
                            </h3>
                        </div>
                        <a href="{{ route('artworks.index') }}" class="group inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium transition-all duration-300"
                           style="color: #DB2077; background: #fce4ec;">
                            <span>View All</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($this->relatedArtworks as $related)
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('artwork.show', encrypt($related->id) ) }}">
                                        <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                             alt="{{ $related->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700">
                                    </a>
                                    @if($related->is_for_sale)
                                        <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold rounded-full" 
                                              style="background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white;">
                                            For Sale
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 space-y-2">
                                    <h6 class="font-bold text-sm line-clamp-1" style="color: #1a0a0f;">
                                        <a href="{{ route('artwork.show', encrypt($related->id)) }}" class="hover:underline">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <p class="text-xs" style="color: #6b3b4f;">
                                        {{ ucfirst(str_replace('_', ' ', $related->style)) }}
                                    </p>
                                    <p class="font-bold text-sm" style="color: #DB2077;">
                                        @if($related->is_for_sale && $related->price)
                                            ₦{{ number_format($related->price, 2) }}
                                        @else
                                            <span style="color: #6b3b4f;">Not for sale</span>
                                        @endif
                                    </p>
                                    <a href="{{ route('artwork.show', encrypt($related->id) ) }}" 
                                       class="block text-center py-2 rounded-xl text-sm font-medium transition-all duration-300 hover:shadow-lg"
                                       style="background: #fce4ec; color: #DB2077;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Enquiry Modal -->
    @if($showEnquiryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" 
             style="background: rgba(26, 10, 15, 0.7); backdrop-filter: blur(8px);"
             wire:click.self="closeEnquiryModal">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto"
                 style="animation: modalSlideIn 0.3s ease-out;">
                
                <!-- Modal Header -->
                <div class="sticky top-0 z-10 px-6 py-4 border-b" style="background: #faf0f5; border-color: #fce4ec;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" 
                                 style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold" style="color: #1a0a0f;">Enquire About This Artwork</h3>
                                <p class="text-xs" style="color: #6b3b4f;">{{ $this->artwork->title }}</p>
                            </div>
                        </div>
                        <button wire:click="closeEnquiryModal" 
                                class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110"
                                style="color: #6b3b4f; background: #fce4ec;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <form wire:submit="submitEnquiry" class="space-y-5">
                        <!-- Artwork Preview -->
                        <div class="flex items-center gap-4 p-3 rounded-xl" style="background: #faf0f5;">
                            <img src="{{ $this->artwork->image ? asset('storage/' . $this->artwork->image) : asset('assets/img/placeholder-artwork.jpg') }}" 
                                 alt="{{ $this->artwork->title }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <p class="font-semibold text-sm" style="color: #1a0a0f;">{{ $this->artwork->title }}</p>
                                <p class="text-xs" style="color: #6b3b4f;">
                                    {{ ucfirst(str_replace('_', ' ', $this->artwork->style)) }}
                                    @if($this->artwork->price)
                                        • ₦{{ number_format($this->artwork->price, 2) }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Full Name <span style="color: #DB2077;">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="enquiryName" 
                                   placeholder="Enter your full name"
                                   class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                            @error('enquiryName') 
                                <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Email Address <span style="color: #DB2077;">*</span>
                            </label>
                            <input type="email" 
                                   wire:model="enquiryEmail" 
                                   placeholder="Enter your email address"
                                   class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                            @error('enquiryEmail') 
                                <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Phone Number <span style="color: #6b3b4f;">(optional)</span>
                            </label>
                            <input type="tel" 
                                   wire:model="enquiryPhone" 
                                   placeholder="Enter your phone number"
                                   class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2"
                                   style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f;">
                            @error('enquiryPhone') 
                                <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Message <span style="color: #DB2077;">*</span>
                            </label>
                            <textarea wire:model="enquiryMessage" 
                                      rows="4"
                                      placeholder="Tell us about your interest in this artwork..."
                                      class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 resize-y"
                                      style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f; min-height: 100px;"></textarea>
                            @error('enquiryMessage') 
                                <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                            @enderror
                            <div class="text-xs mt-1 text-right" style="color: #6b3b4f;">
                                <span x-text="$wire.enquiryMessage.length"></span>/2000 characters
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full py-3.5 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, #DB2077, #ff6b9d);"
                                wire:loading.attr="disabled" 
                                wire:target="submitEnquiry">
                            <span wire:loading.remove wire:target="submitEnquiry">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Enquiry
                            </span>
                            <span wire:loading wire:target="submitEnquiry">
                                <svg class="animate-spin h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24">
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
    @endif

    <style>
        .artwork-details-wrapper {
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

        .duration-700 {
            transition-duration: 700ms;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:scale-110:hover {
            transform: scale(1.1);
        }

        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .hover\:shadow-2xl:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Modal Animation */
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Image hover overlay effect */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #fce4ec;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #DB2077;
            border-radius: 10px;
        }

        /* Focus styles for inputs */
        input:focus, textarea:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        /* Modal scroll */
        .max-h-[90vh] {
            max-height: 90vh;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .artwork-details-section {
                padding: 2rem 1rem;
            }
            
            .grid-cols-4 {
                gap: 0.5rem;
            }
            
            .grid-cols-4 img {
                height: 60px;
            }
        }

        @media (max-width: 640px) {
            .grid-cols-4 {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .grid-cols-4 img {
                height: 50px;
            }
        }

        /* Print styles */
        @media print {
            .breadcrumb-section {
                background: #fce4ec !important;
                color: #1a0a0f !important;
            }
            
            .related-artworks {
                display: none;
            }
            
            button, .action-buttons {
                display: none !important;
            }
        }

        /* Line clamp utility */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth image transitions */
        img {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</div>