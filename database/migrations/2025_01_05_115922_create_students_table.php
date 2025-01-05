<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the users table
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->json('extra_info')->nullable();
            $table->string('profile_picture')->nullable();
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
