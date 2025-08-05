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
use Illuminate\Support\Facades\Log;

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
    Log::info('Academic records:', $academicRecords->toArray());

    $pdf = Pdf::loadView('pdf.student_report', [
        'student' => $student,
        'academicRecords' => $academicRecords,
    ]);

    return response()->streamDownload(
        fn () => print($pdf->output()),
        'student_report.pdf'
    );
}

public static function previewStudentPdf($record)
{
    $student = $record;
    $academicRecords = $student->academicRecords;

    $pdf = Pdf::loadView('pdf.student_report', [
        'student' => $student,
        'academicRecords' => $academicRecords,
    ]);

    return response($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="student_report.pdf"',
    ]);
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
                Tables\Actions\Action::make('previewPdf')
                ->label('Preview')
                ->action(fn ($record) => static::previewStudentPdf($record))
                ->url(fn ($record) => route('filament.admin.resources.students.preview', $record), true),
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
