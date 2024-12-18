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
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key column
            $table->string('ticket_number');
            $table->string('requestor_name');
            $table->unsignedBigInteger('department_id');
            $table->string('location')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('issues_id');
            $table->string('status');
            $table->dateTime('request_datetime');
            $table->dateTime('response_datetime')->nullable();
            $table->dateTime('resolve_datetime')->nullable();
            $table->string('remarks')->nullable();
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
