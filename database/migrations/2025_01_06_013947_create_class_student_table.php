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
        Schema::create('classe_student', function (Blueprint $table) {
            $table->unsignedBigInteger('classe_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        
            // Composite primary key
            $table->primary(['classe_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_student');
    }
};