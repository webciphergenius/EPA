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
        'guardian_name',
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
