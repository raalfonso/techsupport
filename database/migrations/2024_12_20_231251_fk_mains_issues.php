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
        Schema::table('issues', function (Blueprint $table) {
            $table->foreign('mains_id') // Define the foreign key
                  ->references('id') 
                  ->on('mains')
                  ->onDelete('cascade');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('report_id') // Define the foreign key
                  ->references('id') 
                  ->on('reports')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
