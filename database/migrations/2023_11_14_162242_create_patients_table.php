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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // Added cascade on delete to Be able to delete user info
            $table->string('family_code');
            $table->string('emergency_contact');
            $table->string('contact_relation');
            $table->integer('group')->nullable()->default(null);
            $table->date('admission_date')->nullable()->default(null);
            $table->date('last_paid_date')->nullable()->default(null);
            $table->date('last_billed_date')->nullable()->default(null);
            $table->integer('balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
