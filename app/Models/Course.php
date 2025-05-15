<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'credits', // Add other fields as needed
    ];
    //
    public function students()
{
    return $this->belongsToMany(Student::class);
}
public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }

}
