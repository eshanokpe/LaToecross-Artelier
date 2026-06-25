<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        // Get all settings as key => value
        $settings = Setting::pluck('value', 'key');

        return response()->json([
            'about' => [
                'title' => $settings['about_title'] ?? '',
                'content' => $settings['about_content'] ?? '',
            ],
            'social' => [
                'instagram' => $settings['instagram'] ?? '',
                'facebook' => $settings['facebook'] ?? '',
                'tiktok' => $settings['tiktok'] ?? '', // ✅ Added
                'whatsapp' => $settings['whatsapp'] ?? '',
            ],
            'contact' => [
                'phone_1' => $settings['phone_1'] ?? '', // ✅ Added
                'phone_2' => $settings['phone_2'] ?? '', // ✅ Added
                'email_1' => $settings['email_1'] ?? '', // ✅ Added
                'email_2' => $settings['email_2'] ?? '', // ✅ Added
            ],
            'commission_info' => $settings['commission_info'] ?? '',
        ]);
    }
}