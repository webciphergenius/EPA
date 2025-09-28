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
        Schema::table('students', function (Blueprint $table) {
            // Add gender field
            $table->string('gender')->nullable()->after('email');
            
            // Add guardian_name field
            $table->string('guardian_name')->nullable()->after('father_name');
            
            // Drop mother_name and father_name columns
            $table->dropColumn(['mother_name', 'father_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn(['gender', 'guardian_name']);
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
        });
    }
};
