<?php

namespace App\Filament\Resources\AdmissionApplications\Schemas;

use App\Models\AdmissionApplication;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Used when office staff edit an application or enter a paper
 * (walk-in) application themselves.
 */
class AdmissionApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Student')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('student_name')->label("Student's full name")->required()->maxLength(120)->columnSpanFull(),
                        DatePicker::make('date_of_birth')->required()->native(false)->displayFormat('d M Y')->maxDate(now()),
                        Select::make('gender')->options(AdmissionApplication::GENDERS)->required()->native(false),
                        Select::make('class')->label('Class applying for')->options(AdmissionApplication::CLASSES)->required()->native(false),
                        TextInput::make('previous_school')->maxLength(160),
                    ]),
                Section::make('Office')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('status')->options(AdmissionApplication::STATUSES)->default('new')->required()->native(false),
                        TextInput::make('academic_year')->default(AdmissionApplication::ACADEMIC_YEAR)->required()->maxLength(9),
                        Textarea::make('notes')->label('Office notes')->helperText('Only staff see this.')->rows(5),
                    ]),
                Section::make('Guardian')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('guardian_name')->label("Guardian's name")->required()->maxLength(120)->columnSpanFull(),
                        TextInput::make('phone')->label('Mobile number')->tel()->required()->maxLength(20),
                        TextInput::make('email')->email()->maxLength(120),
                        Textarea::make('address')->required()->rows(2)->maxLength(500)->columnSpanFull(),
                    ]),
            ]);
    }
}
