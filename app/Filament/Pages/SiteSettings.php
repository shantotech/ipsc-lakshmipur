<?php

namespace App\Filament\Pages;

use App\Support\Site;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

/**
 * School details, homepage text, announcement bar and logo, all in one place.
 * Empty fields fall back to the built-in default text.
 *
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    protected string $view = 'filament.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Website settings';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Site::formData());
    }

    /** A pair of English + Bangla fields side by side. Placeholders show the current default text. */
    private static function pair(string $key, string $label, bool $long = false, ?string $help = null): Grid
    {
        $make = fn (string $lang) => ($long ? Textarea::make("{$key}_{$lang}")->rows(3) : TextInput::make("{$key}_{$lang}"))
            ->label($label.($lang === 'bn' ? ' (বাংলা)' : ' (English)'))
            ->placeholder(fn () => self::defaultText(Site::TRANSLATED[$key], $lang))
            ->maxLength($long ? 1000 : 255);

        return Grid::make(2)->schema([
            $make('en')->helperText($help),
            $make('bn'),
        ]);
    }

    private static function defaultText(string $translationKey, string $lang): string
    {
        return (string) __($translationKey, [], $lang);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Tabs::make('Settings')
                        ->persistTabInQueryString()
                        ->tabs([
                            Tab::make('School')
                                ->icon(Heroicon::OutlinedBuildingLibrary)
                                ->schema([
                                    Section::make('Logo')
                                        ->description('Shown in the header, footer and browser tab. A square PNG or SVG with a transparent background works best.')
                                        ->schema([
                                            FileUpload::make('logo')
                                                ->hiddenLabel()
                                                ->image()
                                                ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp', 'image/jpeg'])
                                                ->disk('public')
                                                ->directory('branding')
                                                ->maxSize(2048)
                                                ->imagePreviewHeight('120'),
                                        ]),
                                    Section::make('Name')
                                        ->description('Leave a field empty to keep the text shown in grey. An empty Bangla field shows the English text.')
                                        ->schema([
                                            self::pair('school_name', 'School name'),
                                            self::pair('branch', 'Branch'),
                                            self::pair('tagline', 'Tagline'),
                                            self::pair('version', 'Second line'),
                                        ]),
                                ]),
                            Tab::make('Contact')
                                ->icon(Heroicon::OutlinedPhone)
                                ->schema([
                                    Section::make('Contact details')
                                        ->description('Used in the header, footer, contact page and forms.')
                                        ->schema([
                                            Grid::make(3)->schema([
                                                TextInput::make('phone')->label('Main phone')->tel()->placeholder('+880 1XXX-XXXXXX')->maxLength(30),
                                                TextInput::make('phone_2')->label('Second phone (optional)')->tel()->maxLength(30),
                                                TextInput::make('email')->label('Email')->email()->maxLength(120),
                                            ]),
                                            self::pair('address', 'Address', long: true),
                                            self::pair('office_hours', 'Office hours'),
                                        ]),
                                    Section::make('Map and social media')
                                        ->schema([
                                            Grid::make(2)->schema([
                                                TextInput::make('map_query')
                                                    ->label('Map location')
                                                    ->placeholder('International Peace School Lakshmipur')
                                                    ->helperText('What to search on Google Maps, e.g. the school name and area, or "23.9431,90.8286".')
                                                    ->maxLength(255),
                                                TextInput::make('facebook')->label('Facebook page link')->url()->placeholder('https://facebook.com/...')->maxLength(255),
                                                TextInput::make('youtube')->label('YouTube channel link')->url()->placeholder('https://youtube.com/@...')->maxLength(255),
                                            ]),
                                        ]),
                                ]),
                            Tab::make('Homepage')
                                ->icon(Heroicon::OutlinedHome)
                                ->schema([
                                    Section::make('Main homepage text')
                                        ->description('The headline shown on top of the homepage slider (or the welcome section when there are no slides). Fill in both languages: an empty Bangla field shows the English text on the Bangla site.')
                                        ->schema([
                                            self::pair('hero_eyebrow', 'Small label'),
                                            self::pair('hero_title', 'Headline'),
                                            self::pair('hero_text', 'Short text', long: true),
                                        ]),
                                    Section::make('Search engines')
                                        ->collapsed()
                                        ->schema([
                                            self::pair('meta_description', 'Site description', long: true, help: 'One or two sentences shown by Google and when a link is shared.'),
                                        ]),
                                ]),
                            Tab::make('Announcement bar')
                                ->icon(Heroicon::OutlinedMegaphone)
                                ->schema([
                                    Section::make('Yellow bar at the top of every page')
                                        ->description('Visitors can close it; it shows again when you change the text.')
                                        ->schema([
                                            Toggle::make('announcement_enabled')->label('Show the announcement bar'),
                                            self::pair('announcement_text', 'Text'),
                                            self::pair('announcement_link_label', 'Link text'),
                                            TextInput::make('announcement_url')
                                                ->label('Link goes to')
                                                ->placeholder('admission/apply')
                                                ->helperText('A page on this site (e.g. "admission/apply", "notices") or a full web address.')
                                                ->maxLength(255),
                                        ]),
                                ]),
                        ]),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save settings')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Remove the old logo file when it is replaced or removed.
        $oldLogo = Site::raw('logo');
        if ($oldLogo && $oldLogo !== ($data['logo'] ?? null)) {
            Storage::disk('public')->delete($oldLogo);
        }

        Site::save($data);

        Notification::make()->title('Settings saved')->body('The website is updated.')->success()->send();
    }
}
