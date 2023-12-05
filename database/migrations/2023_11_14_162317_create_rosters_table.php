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
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null
            $table->foreignId('supervisor_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->foreignId('caregiver1_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->foreignId('caregiver2_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->foreignId('caregiver3_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->foreignId('caregiver4_id')->constrained(
                table: 'users'
            )->nullOnDelete(); // If deleted dont delete whole roster just set value to null;
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
