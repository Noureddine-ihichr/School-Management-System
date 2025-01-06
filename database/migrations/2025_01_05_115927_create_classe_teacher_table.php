<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create the pivot table directly without trying to modify the classes table
        Schema::create('classe_teacher', function (Blueprint $table) {
            $table->unsignedBigInteger('classe_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->primary(['classe_id', 'teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_teacher');
    }
}; 