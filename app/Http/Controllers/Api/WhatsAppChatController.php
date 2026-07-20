<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Wasender\Wasender;
use App\Models\ContactMessage;

class WhatsAppChatController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'visitor_name' => 'required|string|max:255',
                'visitor_email' => 'required|email|max:255',
                'visitor_message' => 'required|string|max:2000',
                'source' => 'nullable|string',
            ]);

            // Save to database (optional)
            ContactMessage::create([
                'name' => $validated['visitor_name'],
                'email' => $validated['visitor_email'],
                'subject' => 'WhatsApp Widget Chat',
                'message' => $validated['visitor_message'],
                'is_read' => false,
                'source' => $validated['source'] ?? 'whatsapp_widget',
            ]);

            // Get Wasender credentials
            $apiKey = config('services.wasender.api_key');
            $instanceId = config('services.wasender.instance_id');
            $adminPhone = config('services.wasender.admin_phone');

            if (!$apiKey || !$instanceId || !$adminPhone) {
                Log::error('Wasender credentials not configured');
                return response()->json([
                    'success' => false,
                    'message' => 'WhatsApp service is not configured'
                ], 500);
            }

            // Initialize Wasender
            $wasender = new Wasender($apiKey, $instanceId);

            // Format WhatsApp message
            $whatsappMessage = "💬 *New WhatsApp Widget Chat*\n\n"
                . "👤 *Name:* {$validated['visitor_name']}\n"
                . "📧 *Email:* {$validated['visitor_email']}\n"
                . "💬 *Message:*\n{$validated['visitor_message']}\n\n"
                . "_Sent via Website Widget_";

            // Send WhatsApp notification
            $response = $wasender->sendMessage(
                phone: $adminPhone,
                message: $whatsappMessage,
                type: 'text'
            );

            Log::info('WhatsApp Widget Message Sent:', [
                'visitor' => $validated['visitor_name'],
                'response' => $response
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp Widget Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }
}