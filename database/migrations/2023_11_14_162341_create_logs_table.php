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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('caregiver_id')->constrained(
                table: 'users'
            );
            $table->date('date');
            $table->boolean('morning_med');
            $table->boolean('afternoon_med');
            $table->boolean('night_med');
            $table->boolean('breakfast');
            $table->boolean('lunch');
            $table->boolean('dinner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
