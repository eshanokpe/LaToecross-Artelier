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

            'facebook_url'  => Setting::get('facebook_url'),
            'twitter_url'   => Setting::get('twitter_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'linkedin_url'  => Setting::get('linkedin_url'),
            'youtube_url'   => Setting::get('youtube_url'),
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
                                    ->label('About Image')
                                    ->image()
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'])
                                    ->directory('settings')
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
                            ->icon(Heroicon::OutlinedShare)
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

        $aboutImage = is_array($data['about_image'] ?? null)
            ? ($data['about_image'][0] ?? null)
            : ($data['about_image'] ?? null);

        Setting::set('about_title', $data['about_title'] ?? null);
        Setting::set('about_content', $data['about_content'] ?? null, $aboutImage);
        Setting::set('about_image', $aboutImage);

        Setting::set('facebook_url', $data['facebook_url'] ?? null);
        Setting::set('twitter_url', $data['twitter_url'] ?? null);
        Setting::set('instagram_url', $data['instagram_url'] ?? null);
        Setting::set('linkedin_url', $data['linkedin_url'] ?? null);
        Setting::set('youtube_url', $data['youtube_url'] ?? null);

        Setting::set('phone_1', $data['phone_1'] ?? null);
        Setting::set('phone_2', $data['phone_2'] ?? null);
        Setting::set('email_1', $data['email_1'] ?? null);
        Setting::set('email_2', $data['email_2'] ?? null);


        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}