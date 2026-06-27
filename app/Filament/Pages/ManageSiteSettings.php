<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Support\Facades\Storage; // ✅ Added for file deletion

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
            'about_title'   => Setting::get('about_title'),
            'about_content' => Setting::get('about_content'),
            'about_image'   => Setting::get('about_image') ? [Setting::get('about_image')] : null,
            'about_image_2' => Setting::get('about_image_2') ? [Setting::get('about_image_2')] : null,
            'facebook_url'  => Setting::get('facebook_url'),
            'twitter_url'   => Setting::get('twitter_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'linkedin_url'  => Setting::get('linkedin_url'),
            'youtube_url'   => Setting::get('youtube_url'),
            'phone_1'       => Setting::get('phone_1'),
            'phone_2'       => Setting::get('phone_2'),
            'email_1'       => Setting::get('email_1'),
            'email_2'       => Setting::get('email_2'),
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
                                    ->label('Title')
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

                                Textarea::make('about_content')
                                    ->label('Content')
                                    ->rows(8)
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
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->schema([
                                TextInput::make('phone_1')
                                    ->label('Phone')
                                    ->maxLength(255),

                                TextInput::make('phone_2')
                                    ->label('Phone 2')
                                    ->maxLength(255),

                                TextInput::make('email_1')
                                    ->label('Email')
                                    ->maxLength(255),

                                TextInput::make('email_2')
                                    ->label('Email 2')
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

        // Delete old image 1 if changed
        if ($oldImage1 && $oldImage1 !== $newImage1 && Storage::disk('public')->exists($oldImage1)) {
            Storage::disk('public')->delete($oldImage1);
        }

        // Process About Image 2
        $oldImage2 = Setting::get('about_image_2');
        $newImage2 = is_array($data['about_image_2'] ?? null)
            ? ($data['about_image_2'][0] ?? null)
            : ($data['about_image_2'] ?? null);

        // Delete old image 2 if changed
        if ($oldImage2 && $oldImage2 !== $newImage2 && Storage::disk('public')->exists($oldImage2)) {
            Storage::disk('public')->delete($oldImage2);
        }

        // Save all settings
        Setting::set('about_title',   $data['about_title']   ?? null);
        Setting::set('about_content', $data['about_content'] ?? null);
        Setting::set('about_image',   $newImage1);
        Setting::set('about_image_2', $newImage2);

        Setting::set('facebook_url',  $data['facebook_url']  ?? null);
        Setting::set('twitter_url',   $data['twitter_url']   ?? null);
        Setting::set('instagram_url', $data['instagram_url'] ?? null);
        Setting::set('linkedin_url',  $data['linkedin_url']  ?? null);
        Setting::set('youtube_url',   $data['youtube_url']   ?? null);

        Setting::set('phone_1',       $data['phone_1']       ?? null);
        Setting::set('phone_2',       $data['phone_2']       ?? null);
        Setting::set('email_1',       $data['email_1']       ?? null);
        Setting::set('email_2',       $data['email_2']       ?? null);

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}