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
        Schema::create('earned_ctos', function (Blueprint $table) {
            $table->id();
            $table->date('date_logs');
            $table->string('employee_number');
            $table->foreign('employee_number')->references('employee_number')->on('employee_masterlists')->onDelete('cascade');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earned_ctos');
    }
};
