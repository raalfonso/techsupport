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
        Schema::create('request_personnel', function (Blueprint $table) {
            $table->id();
            $table->string('event_title');
            $table->foreignId('requestor_id')->constrained('users', 'id')->onDelete('cascade');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('title');
            $table->text('resource_needed')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_personnel');
    }
};
