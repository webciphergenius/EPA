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
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
