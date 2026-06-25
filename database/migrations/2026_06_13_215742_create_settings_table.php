<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert all default settings including new fields
        DB::table('settings')->insert([
            // About Content
            [
                'key' => 'about_title',
                'value' => 'Welcome to LaToecross Artelier 🎨'
            ],
            [
                'key' => 'about_content',
                'value' => <<<TEXT
We are Akinyemi Olakunle and Akinyemi Omolayo — husband and wife, two artists, one shared heartbeat.

Our story began at Yaba College of Technology, where we both trained and graduated. Yabatech gave us more than a certificate. It gave us discipline, technique, and a deep respect for craft. Those studio years shaped how we see art: as work that must be skilled, honest, and alive.

Omolayo is an artist and fashion designer. She thinks in texture, drape, and movement. Every thread she chooses, every fold she creates, finds its way into the art we make together.

Olakunle is an artist and musician. He hears color. Rhythm guides his brush, and every mural, canvas, or abstract carries the echo of a song he was composing while painting.

Together, we don’t just make art. We build worlds you can step into.

Our hands move across four languages: Realism that honors truth and detail, Impressionism that chases light and mood, Abstract that speaks before words can, and Mixed Media that breaks every rule we were taught.

From statement wall murals that transform entire spaces, to one-of-one canvases that start conversations, to wearable fabric art that lets you carry the story — every piece is handmade by us. No prints. No shortcuts. No two are ever the same.

For collectors and art lovers, this is more than decoration. This is art with a pulse. When you bring a LaToecross piece into your home or space, you bring the laughter we shared while mixing that exact shade of blue. You bring the chord Olakunle played when that brushstroke happened. You bring the fabric Omolayo felt and knew was right.

We create for people who feel deeply, collect intentionally, and want art that means something. Scroll through our collection. See which piece chooses you. Then let’s create something that has never existed before — something that is only yours.

This is LaToecross Artelier. Yabatech-trained. Husband and wife. Infinite color. Let’s create magic together ✨
TEXT
            ],

            // Social Media
            ['key' => 'instagram', 'value' => ''],
            ['key' => 'facebook', 'value' => ''],
            ['key' => 'tiktok', 'value' => ''], // ✅ New
            ['key' => 'whatsapp', 'value' => ''],

            // Contact Details
            ['key' => 'phone_1', 'value' => ''], // ✅ New
            ['key' => 'phone_2', 'value' => ''], // ✅ New
            ['key' => 'email_1', 'value' => ''], // ✅ New
            ['key' => 'email_2', 'value' => ''], // ✅ New

            // Other Info
            [
                'key' => 'commission_info',
                'value' => 'Interested in a custom artwork or fashion piece? Get in touch to discuss your vision, style, size, and budget. We bring your ideas to life with the same passion and skill as all our work.'
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};