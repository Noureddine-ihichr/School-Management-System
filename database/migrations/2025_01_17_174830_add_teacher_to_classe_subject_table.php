<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('classe_subject', function (Blueprint $table) {
            $table->foreignId('teacher_id')->after('subject_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('classe_subject', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};
