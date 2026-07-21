<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage;

new class extends Component
{
    public $visitorName = '';
    public $visitorEmail = '';
    public $visitorPhone = '';
    public $visitorMessage = '';

    protected function rules()
    {
        return [
            'visitorName' => 'required|string|max:255',
            'visitorEmail' => 'required|email|max:255',
            'visitorPhone' => 'nullable|string|max:30',
            'visitorMessage' => 'required|string|max:2000',
        ];
    }

    public function sendMessage()
    {
        $this->validate();

        try {
            ContactMessage::create([
                'name' => $this->visitorName,
                'email' => $this->visitorEmail,
                'phone' => $this->visitorPhone,
                'subject' => 'WhatsApp Widget Chat',
                'message' => $this->visitorMessage,
                'is_read' => false,
                'source' => 'whatsapp_widget',
            ]);

            $apiUrl = config('services.wasender.api_url');
            $token = config('services.wasender.bearer_token');
            $adminPhone = config('services.wasender.admin_phone');

            if (!$apiUrl || !$token || !$adminPhone) {
                Log::error('Wasender configuration missing');
                session()->flash('whatsapp_error', 'System configuration error.');
                return;
            }

            $phoneText = $this->visitorPhone ? "📞 Phone: {$this->visitorPhone}\n" : "📞 Phone: Not provided\n";
            $whatsappText = "💬 *New Website Chat*\n\n"
                . "👤 *Name:* {$this->visitorName}\n"
                . "📧 *Email:* {$this->visitorEmail}\n"
                . $phoneText
                . "💬 *Message:*\n{$this->visitorMessage}";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'to' => $adminPhone,
                'text' => $whatsappText
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp Widget Success:', ['status' => $response->status()]);
                $this->reset(['visitorName', 'visitorEmail', 'visitorPhone', 'visitorMessage']);
                session()->flash('whatsapp_success', 'Message sent! We will reply on WhatsApp shortly.');
            } else {
                Log::error('Wasender API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('API returned status ' . $response->status());
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Widget Exception: ' . $e->getMessage());
            session()->flash('whatsapp_error', 'Failed to send message. Please try again later.');
        }
    }
};
?>

<div>
    <div id="whatsapp-widget" class="whatsapp-widget" x-data="{ open: false }">
        <button 
            @click="open = !open" 
            id="whatsapp-toggle" 
            class="whatsapp-toggle" 
            aria-label="Chat on WhatsApp"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </button>

        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
            id="whatsapp-chat-window" 
            class="whatsapp-chat-window"
            style="display: none;"
        >
            <div class="chat-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Support" class="w-10 h-10 rounded-full object-cover">
                    </div>
                    <div class="chat-header-text">
                        <h4 class="text-white font-semibold text-sm">Latoecross Support</h4>
                        <p class="text-green-200 text-xs">Typically replies within minutes</p>
                    </div>
                </div>
                <button @click="open = false" id="whatsapp-close" class="text-white hover:text-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="chat-body">
                <div class="welcome-message">
                    <p class="text-sm text-gray-700">👋 Hi there! How can we help you today?</p>
                    <p class="text-xs text-gray-500 mt-1">Fill in your details and send us a message.</p>
                </div>

                <div class="whatsapp-direct-link mb-4">
                    <p class="text-xs text-gray-500 mb-2">Or chat with us directly on WhatsApp:</p>
                    <a 
                        href="#"
                        id="whatsapp-direct-link"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition duration-200 w-full justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat on WhatsApp
                    </a>
                </div>

                <div class="divider flex items-center gap-3 my-3">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <span class="text-xs text-gray-400">OR</span>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>

                <form wire:submit.prevent="sendMessage" id="whatsapp-chat-form" class="chat-form space-y-3">
                    <div>
                        <input 
                            type="text" 
                            wire:model="visitorName"
                            placeholder="Your Name *" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                        @error('visitorName') 
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <input 
                            type="email" 
                            wire:model="visitorEmail"
                            placeholder="Your Email *" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                        @error('visitorEmail') 
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <input 
                            type="tel" 
                            wire:model="visitorPhone"
                            placeholder="Your Phone Number" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                        @error('visitorPhone') 
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <textarea 
                            wire:model="visitorMessage"
                            rows="3"
                            placeholder="Type your message... *" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                        ></textarea>
                        @error('visitorMessage') 
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        id="whatsapp-send-btn"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove id="send-text">Send Message</span>
                        <svg wire:loading id="send-spinner" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

                @if (session('whatsapp_success'))
                    <div id="chat-success" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">✅ {{ session('whatsapp_success') }}</p>
                    </div>
                @endif
                
                @if (session('whatsapp_error'))
                    <div id="chat-error" class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-700">❌ {{ session('whatsapp_error') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', initWhatsAppLink);
        document.addEventListener('DOMContentLoaded', initWhatsAppLink);

        function initWhatsAppLink() {
            const link = document.getElementById('whatsapp-direct-link');
            if (!link) return;

            // Remove old listeners to prevent duplicates after Livewire navigation
            const clone = link.cloneNode(true);
            link.parentNode.replaceChild(clone, link);

            clone.addEventListener('click', function(e) {
                e.preventDefault();
                const number = @json(config('services.whatsapp.admin_number'));
                const text = 'Hello, I would like to inquire about artworks and fashions at LaToecross Artelier 🎨';
                window.open(`https://wa.me/${number}?text=${encodeURIComponent(text)}`, '_blank');
            });
        }
    </script>

    <style>
        .whatsapp-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .whatsapp-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #25D366;
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .whatsapp-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        .whatsapp-chat-window {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 350px;
            max-height: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #25D366, #128C7E);
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-avatar img {
            object-fit: cover;
        }

        .chat-body {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .welcome-message {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        @media (max-width: 640px) {
            .whatsapp-chat-window {
                width: calc(100vw - 40px);
                right: -10px;
            }
        }
    </style>
</div>