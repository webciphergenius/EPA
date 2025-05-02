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
                // This assumes the `Student` model has a `name` field
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

            TextInput::make('coursetitle')
                ->label('Course Title')
                ->required()
                ->maxLength(255),
            TextInput::make('grade')
                ->required()
                ->maxLength(10),
            Forms\Components\TextInput::make('credit')
                ->required(),
          TextInput::make('schoolyear')
                ->label('School Year')
                //->displayFormat('Y')
                ->required(),
            TextInput::make('gradelevel')
                ->label('Grade Level')
                ->required()
                ->maxLength(50),
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
