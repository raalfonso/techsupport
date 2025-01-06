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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Primary key (auto-increment)
            $table->string('name'); // Column for client name
            $table->string('email_address')->unique(); // Unique email address
            $table->boolean('active')->default(true); // Active status, default to true
            $table->timestamps(); // Adds created_at and updated_at columns
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
