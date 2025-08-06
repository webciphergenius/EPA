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
        'graduation_date',
        'mother_name',
        'father_name',
        'address',
        'phone_number',
    ];
    protected $casts = [
        'dob' => 'date',
        'graduation_date' => 'date',
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
