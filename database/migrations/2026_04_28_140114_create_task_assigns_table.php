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
        Schema::create('task_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_task_id');
            $table->unsignedBigInteger('assigned_personnel_id');
            $table->enum('status', ['Pending', 'In Process', 'Done'])->default('Pending');
            $table->timestamps();

            $table->foreign('meeting_task_id')->references('id')->on('meeting_tasks')->onDelete('cascade');
            $table->foreign('assigned_personnel_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assigns');
    }
};
