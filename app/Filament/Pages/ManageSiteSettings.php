<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?string $title = 'Site Settings';
    protected static ?int $navigationSort = 4;
    protected string $view = 'filament.pages.manage-site-settings';
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'about_title'              => Setting::get('about_title', 'Discover Our Essence'),
            'about_content'            => Setting::get('about_content', "<p>We are Akinyemi Olakunle and Akinyemi Omolayo husband and wife, two artists, one shared heartbeat.</p><p>Our story began at Yaba College of Technology, where we both trained and graduated. Yabatech gave us more than a certificate. It gave us discipline, technique, and a deep respect for craft. Those studio years shaped how we see art: as work that must be skilled, honest, and alive.</p><p>Omolayo is an artist and fashion designer. She thinks in texture, drape, and movement. Every thread she chooses, every fold she creates, finds its way into the art we make together.</p><p>Olakunle is an artist and musician. He hears color. Rhythm guides his brush, and every mural, canvas, or abstract carries the echo of a song he was composing while painting.</p><p>Together, we don’t just make art. We build worlds you can step into.</p><p>Our hands move across four languages: Realism that honors truth and detail, Impressionism that chases light and mood, Abstract that speaks before words can, and Mixed Media that breaks every rule we were taught.</p><p>From statement wall murals that transform entire spaces, to one-of-one canvases that start conversations, to wearable fabric art that lets you carry the story — every piece is handmade by us. No prints. No shortcuts. No two are ever the same.</p><p>For collectors and art lovers, this is more than decoration. This is art with a pulse. When you bring a LaToecross piece into your home or space, you bring the laughter we shared while mixing that exact shade of blue. You bring the chord Olakunle played when that brushstroke happened. You bring the fabric Omolayo felt and knew was right.</p><p>We create for people who feel deeply, collect intentionally, and want art that means something. Scroll through our collection. See which piece chooses you. Then let’s create something that has never existed before — something that is only yours.</p><p>This is LaToecross Artelier. Yabatech-trained. Husband and wife. Infinite color. Let’s create magic together ✨</p>"),
            'about_image'              => Setting::get('about_image') ? [Setting::get('about_image')] : null,
            'about_image_2'            => Setting::get('about_image_2') ? [Setting::get('about_image_2')] : null,
            
            'vision'                   => Setting::get('vision', "To be recognised globally as a unique creative force — where art, craft, and heart come together — inspiring people to connect deeply with original, meaningful work that reflects authenticity, skill, and soul."),
            'mission'                  => Setting::get('mission', "To create handcrafted art and design that blends technical excellence with personal expression. Rooted in our training at Yaba College of Technology, we work across Realism, Impressionism, Abstract, and Mixed Media to produce one-of-a-kind pieces — from canvases and murals to wearable art — made entirely by our hands, with no shortcuts, so every creation carries the story, rhythm, and feeling behind it."),
            'what_makes_special'       => Setting::get('what_makes_special', "<ul><li><strong>A partnership in art:</strong> We are husband and wife — two artists, one shared vision. Our work combines Omolayo’s eye for texture, form, and design with Olakunle’s musical sense of rhythm, colour, and flow.</li><li><strong>Proven craft:</strong> Trained and educated at Yaba College of Technology, we bring discipline, technique, and deep respect for traditional and contemporary artistic practice to every piece.</li><li><strong>No mass production:</strong> Every artwork is 100% handmade — no prints, no reproductions, no two pieces are ever identical.</li><li><strong>Multidisciplinary approach:</strong> We speak four artistic languages — Realism, Impressionism, Abstract, and Mixed Media — giving you work that ranges from faithful detail to bold, emotional expression.</li><li><strong>Art with a story:</strong> When you own a LaToecross piece, you bring home more than just a visual — you bring the mood, the sound, and the moments we shared while creating it.</li><li><strong>Made for connection:</strong> We create for those who collect with intention, value originality, and want art that feels alive and personal.</li></ul>"),
            'what_makes_special_image' => Setting::get('what_makes_special_image') ? [Setting::get('what_makes_special_image')] : null,

            'facebook_url'             => Setting::get('facebook_url'),
            'twitter_url'              => Setting::get('twitter_url'),
            'instagram_url'            => Setting::get('instagram_url'),
            'linkedin_url'             => Setting::get('linkedin_url'),
            'youtube_url'              => Setting::get('youtube_url'),
            'phone_1'                  => Setting::get('phone_1'),
            'phone_2'                  => Setting::get('phone_2'),
            'email_1'                  => Setting::get('email_1'),
            'email_2'                  => Setting::get('email_2'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('About Us')
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->schema([
                                TextInput::make('about_title')
                                    ->label('About Title')
                                    ->maxLength(255),

                                FileUpload::make('about_image')
                                    ->label('About Image 1')
                                    ->image()
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'])
                                    ->directory('settings')
                                    ->disk('public')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                FileUpload::make('about_image_2')
                                    ->label('About Image 2')
                                    ->image()
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'])
                                    ->directory('settings')
                                    ->disk('public')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                // ✅ Corrected: use height() instead of rows()
                                RichEditor::make('about_content')
                                    ->label('Full About Content')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike',
                                        'bulletList', 'orderedList', 'link', 'blockquote',
                                        'h2', 'h3', 'paragraph', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull(),

                                Textarea::make('vision')
                                    ->label('Our Vision')
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Textarea::make('mission')
                                    ->label('Our Mission')
                                    ->rows(4)
                                    ->columnSpanFull(),

                                // ✅ Corrected: use height() instead of rows()
                                RichEditor::make('what_makes_special')
                                    ->label('What Makes Us Special')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline',
                                        'bulletList', 'orderedList', 'link', 'blockquote',
                                        'h3', 'paragraph', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull(),

                                FileUpload::make('what_makes_special_image')
                                    ->label('What Makes Us Special Image')
                                    ->image()
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'])
                                    ->directory('settings')
                                    ->disk('public')
                                    ->imageEditor()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Social Media')
                            ->icon(Heroicon::OutlinedShare)
                            ->schema([
                                TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->prefixIcon(Heroicon::OutlinedLink),

                                TextInput::make('twitter_url')
                                    ->label('Twitter / X URL')
                                    ->url()
                                    ->prefixIcon(Heroicon::OutlinedLink),

                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->prefixIcon(Heroicon::OutlinedLink),

                                TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->prefixIcon(Heroicon::OutlinedLink),

                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->prefixIcon(Heroicon::OutlinedLink),
                            ])
                            ->columns(2),

                        Tab::make('Site Detail')
                            ->icon(Heroicon::OutlinedPhone)
                            ->schema([
                                TextInput::make('phone_1')
                                    ->label('Primary Phone')
                                    ->maxLength(255),

                                TextInput::make('phone_2')
                                    ->label('Secondary Phone')
                                    ->maxLength(255),

                                TextInput::make('email_1')
                                    ->label('Primary Email')
                                    ->maxLength(255),

                                TextInput::make('email_2')
                                    ->label('Secondary Email')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Process About Image 1
        $oldImage1 = Setting::get('about_image');
        $newImage1 = is_array($data['about_image'] ?? null)
            ? ($data['about_image'][0] ?? null)
            : ($data['about_image'] ?? null);

        if ($oldImage1 && $oldImage1 !== $newImage1 && Storage::disk('public')->exists($oldImage1)) {
            Storage::disk('public')->delete($oldImage1);
        }

        // Process About Image 2
        $oldImage2 = Setting::get('about_image_2');
        $newImage2 = is_array($data['about_image_2'] ?? null)
            ? ($data['about_image_2'][0] ?? null)
            : ($data['about_image_2'] ?? null);

        if ($oldImage2 && $oldImage2 !== $newImage2 && Storage::disk('public')->exists($oldImage2)) {
            Storage::disk('public')->delete($oldImage2);
        }

        // Process What Makes Us Special Image
        $oldSpecialImage = Setting::get('what_makes_special_image');
        $newSpecialImage = is_array($data['what_makes_special_image'] ?? null)
            ? ($data['what_makes_special_image'][0] ?? null)
            : ($data['what_makes_special_image'] ?? null);

        if ($oldSpecialImage && $oldSpecialImage !== $newSpecialImage && Storage::disk('public')->exists($oldSpecialImage)) {
            Storage::disk('public')->delete($oldSpecialImage);
        }

        // Save all settings
        Setting::set('about_title',              $data['about_title'] ?? null);
        Setting::set('about_content',            $data['about_content'] ?? null);
        Setting::set('about_image',              $newImage1);
        Setting::set('about_image_2',            $newImage2);

        Setting::set('vision',                   $data['vision'] ?? null);
        Setting::set('mission',                  $data['mission'] ?? null);
        Setting::set('what_makes_special',       $data['what_makes_special'] ?? null);
        Setting::set('what_makes_special_image', $newSpecialImage);

        Setting::set('facebook_url',             $data['facebook_url'] ?? null);
        Setting::set('twitter_url',              $data['twitter_url'] ?? null);
        Setting::set('instagram_url',            $data['instagram_url'] ?? null);
        Setting::set('linkedin_url',             $data['linkedin_url'] ?? null);
        Setting::set('youtube_url',              $data['youtube_url'] ?? null);

        Setting::set('phone_1',                  $data['phone_1'] ?? null);
        Setting::set('phone_2',                  $data['phone_2'] ?? null);
        Setting::set('email_1',                  $data['email_1'] ?? null);
        Setting::set('email_2',                  $data['email_2'] ?? null);

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}