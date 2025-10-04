<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'name',
        'dob',
        'email',
        'gender',
        'graduation_date',
        'issue_date',
        'note',
        'guardian_name',
        'address',
        'phone_number',
        'counselor',
    ];
    protected $casts = [
        'dob' => 'date',
        'graduation_date' => 'date',
        'issue_date' => 'date',
    ];
    public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }
    public function courses()
{
    return $this->belongsToMany(Course::class);
}
}
