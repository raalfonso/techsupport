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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('terminal_id')->default('online');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('employee_id');
            $table->string('class')->default('User');
            $table->enum('mode', ['Attend', 'Leave']);
            $table->string('type')->nullable();
            $table->string('card_serial')->nullable();
            $table->string('result')->nullable();
            $table->string('property')->nullable();
            $table->string('external_device')->nullable();
            $table->string('coordinate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
