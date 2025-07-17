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
        Schema::create('education', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('highest_degree');
            $table->string('institution_name');
            $table->text('additional_certifications')->nullable(); // Optional field
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
