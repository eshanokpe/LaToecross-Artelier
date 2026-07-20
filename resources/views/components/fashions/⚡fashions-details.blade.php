<?php

use Livewire\Component;
use App\Models\Fashion;
use App\Models\FashionEnquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; // ✅ Added for Wasender API
use App\Mail\FashionEnquiryMail;

new class extends Component
{
    public Fashion $fashion;
    public $relatedFashions = [];
    public $categories = [];
    
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
    
    public function mount(Fashion $fashion, $categories = [])
    {
        $this->fashion = $fashion;
        $this->categories = $categories;
        $this->loadRelatedFashions();
    }
    
    public function loadRelatedFashions()
    {
        $this->relatedFashions = Fashion::where('id', '!=', $this->fashion->id)
            ->where('category', $this->fashion->category)
            ->where('is_for_sale', true)
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
        $enquiry = FashionEnquiry::create([
            'fashion_id' => $this->fashion->id,
            'name' => $this->enquiryName,
            'email' => $this->enquiryEmail,
            'phone' => $this->enquiryPhone,
            'message' => $this->enquiryMessage,
            'is_read' => false,
        ]);
        
        // Send email notification
        try {
            $recipients = array_map('trim', explode(',', config('mail.admin_alerts')));
            Mail::to($recipients)->send(new FashionEnquiryMail($enquiry, $this->fashion));
        } catch (\Exception $e) {
            // Log error but don't fail
            Log::error('Failed to send fashion enquiry email: ' . $e->getMessage());
        }
 
        // ✅ WhatsApp notification using Wasender API
        try { 
            // Add these to your .env file:
            // WASENDER_API_URL=https://wasenderapi.com/api/send-message
            // WASENDER_BEARER_TOKEN=9b2c787349d305f72c0fc247f37e25684bbfac4af87ce195e042a4d729dd9eb1
            // WASENDER_ADMIN_PHONE=+1234567890
            
            $apiUrl     = config('services.wasender.api_url');
            $token      = config('services.wasender.bearer_token');
            $adminPhone = config('services.wasender.admin_phone');

            if (empty($apiUrl) || empty($token) || empty($adminPhone)) {
                Log::error('Wasender credentials missing in .env');
                session()->flash('enquiry_warning', 'Enquiry saved, WhatsApp config incomplete.');
            } else {
                // ✅ FORMAT MESSAGE FOR WHATSAPP
                $whatsappMessage = "👗 *New Fashion Enquiry*\n\n"
                    . "🏷️ *Item:* {$this->fashion->title}\n"
                    . "👤 *Name:* {$this->enquiryName}\n"
                    . "📧 *Email:* {$this->enquiryEmail}\n"
                    . "📞 *Phone:* " . ($this->enquiryPhone ?: 'Not provided') . "\n\n"
                    . "💬 *Message:*\n{$this->enquiryMessage}";

                // ✅ SEND REQUEST USING LARAVEL HTTP CLIENT (Matches your cURL)
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                ])->post($apiUrl, [
                    'to'   => $adminPhone,
                    'text' => $whatsappMessage
                ]);

                if ($response->successful()) {
                    Log::info('Wasender Send Success:', $response->json());
                } else {
                    Log::warning('Wasender Send Failed:', [
                        'status' => $response->status(),
                        'body'   => $response->body()
                    ]);
                    session()->flash('enquiry_warning', 'Enquiry saved, but WhatsApp alert failed.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Fashion Enquiry WhatsApp Error: ' . $e->getMessage());
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

<div>
    <!-- Fashion Details -->
    <section class="fashion-details py-12 md:py-16" style="background: linear-gradient(180deg, #FFFFFF 0%, #faf0f5 100%);">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Image -->
                    <div class="rounded-2xl overflow-hidden shadow-xl">
                        <img src="{{ $fashion->image ? asset('storage/' . $fashion->image) : asset('assets/img/placeholder-fashion.jpg') }}" 
                             alt="{{ $fashion->title }}"
                             class="w-full h-auto object-cover">
                    </div>

                    <!-- Details -->
                    <div class="space-y-6">
                        <div>
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <span class="text-sm font-semibold px-3 py-1 rounded-full" style="color: #DB2077; background: #fce4ec;">
                                    {{ $categories[$fashion->category] ?? $fashion->category }}
                                </span>
                                @if($fashion->is_featured)
                                    <span class="text-sm font-semibold px-3 py-1 rounded-full" style="background: #fce4ec; color: #DB2077;">
                                        ★ Featured
                                    </span>
                                @endif
                                @if($fashion->is_for_sale)
                                    <span class="text-sm font-semibold px-3 py-1 rounded-full" style="background: #22c55e; color: white;">
                                        Available
                                    </span>
                                @else
                                    <span class="text-sm font-semibold px-3 py-1 rounded-full" style="background: #1a0a0f; color: white;">
                                        Sold Out
                                    </span>
                                @endif
                            </div>
                            <h2 class="text-3xl font-bold" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                                {{ $fashion->title }}
                            </h2>
                        </div>

                        <!-- Price -->
                        <div class="p-4 rounded-2xl" style="background: #fce4ec;">
                            <p class="text-sm" style="color: #6b3b4f;">Price</p>
                            <p class="text-3xl font-bold" style="color: #DB2077;">
                                @if($fashion->is_for_sale && $fashion->price)
                                    ₦{{ number_format($fashion->price, 2) }}
                                @else
                                    <span style="color: #6b3b4f;">Not for sale</span>
                                @endif
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <h4 class="text-lg font-bold mb-2" style="color: #1a0a0f;">Description</h4>
                            <p class="text-gray-700 leading-relaxed" style="color: #2d1b24;">
                                {{ $fashion->description ?? 'No description available.' }}
                            </p>
                        </div>

                        <!-- Details Grid with Dimensions -->
                        <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl" style="background: #faf0f5;">
                            @if($fashion->designer)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Designer</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $fashion->designer }}</p>
                                </div>
                            @endif
                            @if($fashion->material)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Material</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $fashion->material }}</p>
                                </div>
                            @endif
                            @if($fashion->size)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Size</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $fashion->size }}</p>
                                </div>
                            @endif
                            @if($fashion->color)
                                <div>
                                    <p class="text-sm" style="color: #6b3b4f;">Color</p>
                                    <div class="flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full border" style="background: {{ $fashion->color }};"></span>
                                        <span class="font-medium" style="color: #1a0a0f;">{{ $fashion->color }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($fashion->dimensions)
                                <div class="col-span-2">
                                    <p class="text-sm" style="color: #6b3b4f;">Dimensions</p>
                                    <p class="font-medium" style="color: #1a0a0f;">{{ $fashion->dimensions }}</p>
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

                        <!-- Enquiry Button -->
                            <button wire:click="openEnquiryModal" 
                                    class="w-full py-3.5 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2"
                                    style="background: linear-gradient(135deg, #DB2077, #ff6b9d);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span>Make Enquiry</span>
                            </button>
                        
                           
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Fashions -->
    @if($relatedFashions->count() > 0)
        <section class="related-fashions py-12" style="background: #faf0f5;">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-8">
                        <span class="inline-block font-semibold text-sm uppercase tracking-wider px-4 py-1.5 rounded-full" style="color: #DB2077; background: #fce4ec;">
                            You May Also Like
                        </span>
                        <h3 class="text-2xl font-bold mt-3" style="color: #1a0a0f; font-family: 'Georgia', serif;">
                            Related Fashions
                        </h3>
                        <div class="w-24 h-1 mx-auto mt-3 rounded-full" style="background: linear-gradient(90deg, #DB2077, #ff6b9d, #ff9ec4);"></div>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedFashions as $related)
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('fashion.show', encrypt($related->id) ) }}">
                                        <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('assets/img/placeholder-fashion.jpg') }}" 
                                             alt="{{ $related->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700"
                                             loading="lazy">
                                    </a>
                                    @if($related->is_featured)
                                        <span class="absolute top-3 right-3 px-2 py-0.5 text-[10px] font-bold rounded-full" 
                                              style="background: #fce4ec; color: #DB2077;">
                                            ★
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h6 class="font-bold line-clamp-1" style="color: #1a0a0f;">
                                        <a href="{{ route('fashion.show',  encrypt($related->id) ) }}" class="hover:underline">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <p class="text-xs mt-1" style="color: #6b3b4f;">
                                        {{ $categories[$related->category] ?? $related->category }}
                                    </p>
                                    <p class="text-sm mt-1" style="color: #DB2077; font-weight: 600;">
                                        ₦{{ number_format($related->price, 2) }}
                                    </p>
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
                                <h3 class="text-lg font-bold" style="color: #1a0a0f;">Enquire About This Fashion</h3>
                                <p class="text-xs" style="color: #6b3b4f;">{{ $fashion->title }}</p>
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
                    <!-- Fashion Preview -->
                    <div class="flex items-center gap-4 p-3 rounded-xl mb-4" style="background: #faf0f5;">
                        <img src="{{ $fashion->image ? asset('storage/' . $fashion->image) : asset('assets/img/placeholder-fashion.jpg') }}" 
                             alt="{{ $fashion->title }}"
                             class="w-16 h-16 object-cover rounded-lg">
                        <div>
                            <p class="font-semibold text-sm" style="color: #1a0a0f;">{{ $fashion->title }}</p>
                            <p class="text-xs" style="color: #6b3b4f;">
                                {{ $categories[$fashion->category] ?? $fashion->category }}
                                @if($fashion->price)
                                    • ₦{{ number_format($fashion->price, 2) }}
                                @endif
                            </p>
                            @if($fashion->dimensions)
                                <p class="text-xs" style="color: #6b3b4f;">Dimensions: {{ $fashion->dimensions }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="submitEnquiry" class="space-y-4">
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

                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #1a0a0f;">
                                Message <span style="color: #DB2077;">*</span>
                            </label>
                            <textarea wire:model="enquiryMessage" 
                                      rows="4"
                                      placeholder="Tell us about your interest in this fashion piece..."
                                      class="w-full px-4 py-3 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 resize-y"
                                      style="border-color: #e5d0d8; background: #faf0f5; color: #1a0a0f; min-height: 100px;"></textarea>
                            @error('enquiryMessage') 
                                <span class="text-xs mt-1 block" style="color: #DB2077;">{{ $message }}</span> 
                            @enderror
                            <div class="text-xs mt-1 text-right" style="color: #6b3b4f;">
                                <span x-text="$wire.enquiryMessage.length"></span>/2000 characters
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full py-3.5 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, #DB2077, #ff6b9d);"
                                wire:loading.attr="disabled" 
                                wire:target="submitEnquiry">
                            <span wire:loading.remove wire:target="submitEnquiry">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Enquiry
                            </span>
                            <span wire:loading wire:target="submitEnquiry">
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
    @endif

    <style>
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

        /* Line clamp */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Focus styles */
        input:focus, textarea:focus {
            border-color: #DB2077 !important;
            box-shadow: 0 0 0 3px rgba(219, 32, 119, 0.1);
        }

        /* Loading spinner */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</div>