<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAcademicRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('academic_records', function (Blueprint $table) {
            // Modify the grade column to be a string
            $table->string('grade')->change();
            // Modify the schoolyear column to be a string
            $table->string('schoolyear')->change();
        });
    }

    public function down()
    {
        Schema::table('academic_records', function (Blueprint $table) {
            // Revert changes if needed
            $table->integer('grade')->change(); // If it was previously an integer
            $table->year('schoolyear')->change(); // If it was previously a year
        });
    }
}
