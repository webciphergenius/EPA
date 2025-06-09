<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicRecordResource\Pages;
use App\Filament\Resources\AcademicRecordResource\RelationManagers;
use App\Models\AcademicRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\NumberInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class AcademicRecordResource extends Resource
{
    protected static ?string $model = AcademicRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\Select::make('student_id')
            ->label('Student')
            ->relationship('student', 'name')  
            ->required()
            ->searchable()
            ->getSearchResultsUsing(function (string $search) {
                return \App\Models\Student::query()
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->limit(50)
                    ->pluck('name', 'id')
                    ->mapWithKeys(function ($name, $id) {
                        $student = \App\Models\Student::find($id);
                        return [$id => "{$name} ({$student->email})"];
                    });
            })
            ->getOptionLabelUsing(fn ($value) => \App\Models\Student::find($value)?->name ?? 'N/A')
            ->placeholder('Search by name or email'),

        Forms\Components\Select::make('coursetitle')
            ->label('Course')
            //->relationship('course', 'name') // Assuming the AcademicRecord model has a `course` relationship
            ->options(\App\Models\Course::query()->pluck('name', 'name')) 
            ->required()
            ->searchable()
            ->reactive() // Make it reactive to fetch course credits
            ->placeholder('Select a course')
            ->afterStateUpdated(function (callable $set, $state) {
                if ($state) {
                    $course = \App\Models\Course::where('name', $state)->first();
            $set('credit', $course?->credits ?? 0); // Set default to 0 if no credits are found
                }
            }),
        Forms\Components\TextInput::make('credit')
        ->label('Credits')
        ->required(),
       // ->disabled(), // Ensure this field cannot be manually edited
        
       Select::make('grade')
    ->label('Grade')
    ->options([
        'A+' => 'A+',
        'A' => 'A',
        'A-' => 'A-',
        'B+' => 'B+',
        'B' => 'B',
        'B-' => 'B-',
        'C+' => 'C+',
        'C' => 'C',
        'C-' => 'C-',
        'D+' => 'D+',
        'D' => 'D',
        'D-' => 'D-',
        'F' => 'F',
        'I' => 'I',
    ])
    ->default('A') // Set default value here
    ->required(),

    Select::make('schoolyear')
    ->label('School Year')
    ->options([
        '2024-2025' => '2024-2025',
        '2025-2026' => '2025-2026',
        '2026-2027' => '2026-2027',
        '2027-2028' => '2027-2028',
        '2028-2029' => '2028-2029',
        '2029-2030' => '2029-2030',
        '2030-2031' => '2030-2031',
    ])
    ->default('2024-2025'),

        
Select::make('gradelevel')
->label('Grade Level')
->options([
    '9TH' => '9TH',
    '10TH' => '10TH',
    '11TH' => '11TH',
    '12TH' => '12TH',
])
->default('9TH') // Optional default
->required(),
    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('student.name') // Access the 'name' through the relationship
                ->label('Student Name')
                ->sortable()
                ->searchable(),
                TextColumn::make('student.email') // Access the 'name' through the relationship
                ->label('Email Address')
                ->sortable()
                ->searchable(),
        
                TextColumn::make('coursetitle')->sortable()->searchable(),
                TextColumn::make('grade')->sortable(),
                TextColumn::make('credit')->sortable(),
                TextColumn::make('schoolyear')->label('School Year'),
                TextColumn::make('gradelevel')->label('Grade Level'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicRecords::route('/'),
            'create' => Pages\CreateAcademicRecord::route('/create'),
            'edit' => Pages\EditAcademicRecord::route('/{record}/edit'),
        ];
    }
}
