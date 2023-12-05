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
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); // Deletes row if patient is deleted
            $table->foreignId('caregiver_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->date('date');
            $table->boolean('morning_med')->nullable()->default(null);
            $table->boolean('afternoon_med')->nullable()->default(null);
            $table->boolean('night_med')->nullable()->default(null);
            $table->boolean('breakfast')->nullable()->default(null);
            $table->boolean('lunch')->nullable()->default(null);
            $table->boolean('dinner')->nullable()->default(null);
            $table->unique(array('patient_id', 'date'));
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
