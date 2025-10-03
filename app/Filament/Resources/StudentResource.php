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
use Filament\Forms\Components\Select;
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
                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])
                    ->nullable(),
                DatePicker::make('graduation_date')
                    ->label('Graduation Date')
                    ->nullable(),
                TextInput::make('guardian_name')
                    ->label('Guardian Name')
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->maxLength(255),
                TextInput::make('counselor')
                    ->label('Counselor')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }
    public static function exportStudentPdf($record)
{
    // Get fresh data from database to ensure we have the latest counselor information
    $student = Student::find($record->id);
    $academicRecords = $student->academicRecords;
    
    Log::info('Student data for PDF:', $student->toArray());
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
    // Get fresh data from database to ensure we have the latest counselor information
    $student = Student::find($record->id);
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
                TextColumn::make('gender')->label('Gender'),
                TextColumn::make('graduation_date')->label('Graduation Date')->date(),
                TextColumn::make('guardian_name')->label('Guardian Name'),
                TextColumn::make('address')->label('Address'),
                TextColumn::make('phone_number')->label('Phone Number'),
                TextColumn::make('counselor')->label('Counselor')->sortable()->searchable(),
                
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
