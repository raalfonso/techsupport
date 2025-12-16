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
        Schema::create('history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('report_id');
            $table->string('status');
            $table->string('action');
            $table->unsignedBigInteger('performed_by');
            $table->timestamps();
            $table->foreign('report_id') // Define the foreign key
                  ->references('id') 
                  ->on('reports')
                  ->onDelete('cascade');
            $table->foreign('performed_by') // Define the foreign key
                  ->references('id') 
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
        $table->dropForeign(['user_id']); // Drop the foreign key
        $table->dropForeign(['performed_by']); // Drop the foreign key
    }
};
