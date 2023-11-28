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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('medication_name');
            $table->string('medication_dosage');
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('doctor_id')->constrained(
                table: 'users'
            );
            $table->foreignId('morning_med')->nullable()->constrained(
                table: 'prescriptions'
            );
            $table->foreignId('afternoon_med')->nullable()->constrained(
                table: 'prescriptions'
            );
            $table->foreignId('night_med')->nullable()->constrained(
                table: 'prescriptions'
            );
            $table->date('date');
            $table->string('comments')->nullable(); // comments need to be null to create appointments
            $table->unique(array('patient_id', 'date'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('appointments');
    }
};
