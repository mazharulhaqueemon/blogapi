<?php

use Illuminate\Database\Eloquent\Relations\Relation;
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
        Schema::create('personalinfos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade'); //
            $table->date('date_of_birth');
            $table->string('blood_group')->nullable();
            $table->string('height')->nullable(); // Example: "5'7"" or cm
            $table->string('weight')->nullable();
            $table->string('body_type')->nullable();
            $table->string('marital_status');
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Sikhism', 'Jainism', 'Other'])->default('Islam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalinfos');
    }
};
