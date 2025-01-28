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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('department_id');
            $table->string('location')->nullable();
            $table->unsignedBigInteger('issues_id');
            $table->string('status');
            $table->text('procedure')->nullable();
            $table->dateTime('request_datetime');
            $table->unsignedBigInteger('response_by')->nullable();
            $table->unsignedBigInteger('resolve_id')->nullable();
            $table->unsignedBigInteger('escalated_to')->nullable();
            $table->dateTime('response_datetime')->nullable();
            $table->dateTime('resolve_datetime')->nullable();
            $table->text('remarks')->nullable();
            $table->string('feedback')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
