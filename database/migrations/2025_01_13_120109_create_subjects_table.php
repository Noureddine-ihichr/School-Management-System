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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->unique(); // Subject name (must be unique)
            $table->string('code')->nullable(); // Optional subject code
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // Created and updated timestamps
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
