<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\StudentResource;

use App\Models\Student;

Route::get('/', function () {
    return view('welcome');
    //return view('student_report');
});
Route::get('/pdf', function () {
    return view('student_report');
});

Route::get('/admin/students/{record}/preview', function (Student $record) {
    // Get fresh data from database to ensure we have the latest counselor information
    $student = Student::find($record->id);
    return StudentResource::previewStudentPdf($student);
})->name('filament.admin.resources.students.preview');

Route::get('/admin/students/{record}/preview-unofficial', function (Student $record) {
    // Get fresh data from database to ensure we have the latest counselor information
    $student = Student::find($record->id);
    return StudentResource::previewUnofficialStudentPdf($student);
})->name('filament.admin.resources.students.preview-unofficial');