<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;
class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                DatePicker::make('graduation_date')
                    ->label('Graduation Date')
                    ->nullable(),
                TextInput::make('mother_name')
                    ->label("Mother's Name")
                    ->maxLength(255),
                TextInput::make('father_name')
                    ->label("Father's Name")
                    ->maxLength(255),
            ]);
    }
    public static function exportStudentPdf($record)
{
    $student = $record;
    $academicRecords = $student->academicRecords;
    
    $pdf = Pdf::loadView('pdf.student_report', [
        'student' => [
            'name' => mb_convert_encoding($student->name, 'UTF-8', 'UTF-8'),
            'email' => mb_convert_encoding($student->email, 'UTF-8', 'UTF-8'),
        ],
        'academicRecords' => $academicRecords->map(function ($record) {
            return [
                'coursetitle' => mb_convert_encoding($record->coursetitle, 'UTF-8', 'UTF-8'),
                'grade' => mb_convert_encoding($record->grade, 'UTF-8', 'UTF-8'),
                'credit' => mb_convert_encoding($record->credit, 'UTF-8', 'UTF-8'),
                'schoolyear' => mb_convert_encoding($record->schoolyear, 'UTF-8', 'UTF-8'),
                'gradelevel' => mb_convert_encoding($record->gradelevel, 'UTF-8', 'UTF-8'),
            ];
        }),
    ]);
    return response()->streamDownload(
        fn () => print($pdf->output()),
        'student_report.pdf'
    );
    
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('dob')->label('Date of Birth')->date(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('graduation_date')->label('Graduation Date')->date(),
                TextColumn::make('mother_name')->label("Mother's Name"),
                TextColumn::make('father_name')->label("Father's Name"),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('exportPdf')
                ->label('Export as PDF')
                ->action(fn ($record) => static::exportStudentPdf($record)),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
