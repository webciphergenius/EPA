<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'student_id',
        'coursetitle',
        'grade',
        'credit',
        'schoolyear',
        'gradelevel',
        'counselor',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function course()
{
    return $this->belongsTo(Course::class);
}
    public function getCoursetitleAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function getGradeAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function getCreditAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function getSchoolyearAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function getGradelevelAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function getCounselorAttribute($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}
