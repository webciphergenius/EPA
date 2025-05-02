<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Student Name
            $table->date('dob'); // Date of Birth
            $table->string('email')->unique(); // Email (unique)
            $table->date('graduation_date')->nullable(); // Graduation Date, nullable if unknown
            $table->string('mother_name'); // Mother's Name
            $table->string('father_name'); // Father's Name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
