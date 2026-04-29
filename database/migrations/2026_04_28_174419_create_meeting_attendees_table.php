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
        Schema::create('meeting_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('meeting_detail_id')->constrained('meeting_details')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate attendees for the same meeting
            $table->unique(['attendee_id', 'meeting_detail_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_attendees');
    }
};
