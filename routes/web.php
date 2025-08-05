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
    return StudentResource::previewStudentPdf($record);
})->name('filament.admin.resources.students.preview');