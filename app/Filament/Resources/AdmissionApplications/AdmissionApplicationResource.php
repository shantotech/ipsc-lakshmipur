<?php

namespace App\Filament\Resources\AdmissionApplications;

use App\Filament\Resources\AdmissionApplications\Pages\CreateAdmissionApplication;
use App\Filament\Resources\AdmissionApplications\Pages\EditAdmissionApplication;
use App\Filament\Resources\AdmissionApplications\Pages\ListAdmissionApplications;
use App\Filament\Resources\AdmissionApplications\Pages\ViewAdmissionApplication;
use App\Filament\Resources\AdmissionApplications\Schemas\AdmissionApplicationForm;
use App\Filament\Resources\AdmissionApplications\Schemas\AdmissionApplicationInfolist;
use App\Filament\Resources\AdmissionApplications\Tables\AdmissionApplicationsTable;
use App\Models\AdmissionApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AdmissionApplicationResource extends Resource
{
    protected static ?string $model = AdmissionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Admissions';

    protected static ?string $modelLabel = 'application';

    protected static ?string $recordTitleAttribute = 'student_name';

    public static function form(Schema $schema): Schema
    {
        return AdmissionApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdmissionApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdmissionApplicationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdmissionApplications::route('/'),
            'create' => CreateAdmissionApplication::route('/create'),
            'view' => ViewAdmissionApplication::route('/{record}'),
            'edit' => EditAdmissionApplication::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['reference', 'student_name', 'guardian_name', 'phone'];
    }

    /** Number of new applications waiting, shown next to the menu item. */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'New applications';
    }
}
