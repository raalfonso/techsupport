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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_details_id')->constrained('meeting_details')->onDelete('cascade');
            $table->string('title');
            $table->text('details')->nullable();
            $table->enum('status', ['In Process', 'Pending', 'Done'])->default('Pending');
            $table->string('assigned_personnel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
