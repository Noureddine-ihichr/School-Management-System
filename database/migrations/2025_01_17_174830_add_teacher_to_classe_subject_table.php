<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherToClasseSubjectTable extends Migration
{
    public function up()
    {
        Schema::table('classe_subject', function (Blueprint $table) {
            $table->foreignId('teacher_id')->after('subject_id')->constrained('teachers')->onDelete('cascade');
            // Make sure a subject is assigned only once per class-teacher combination
            $table->unique(['classe_id', 'subject_id', 'teacher_id']);
        });
    }

    public function down()
    {
        Schema::table('classe_subject', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
}
