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
        Schema::create('wfh_accomplishment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('department_id');
            $table->longText('accomplishment');
            $table->date('date');
            $table->timestamps();

            // Foreign keys
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            // Indexes
            $table->index('employee_id');
            $table->index('department_id');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wfh_accomplishment');
    }
};
