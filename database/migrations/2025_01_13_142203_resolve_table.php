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
        Schema::create('resolve', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('resolve', function (Blueprint $table) {
            $table->foreign('report_id') // Define the foreign key
                  ->references('id') 
                  ->on('reports')
                  ->onDelete('cascade');
            
        });

        Schema::table('resolve', function (Blueprint $table) {
            $table->foreign('user_id') // Define the foreign key
                  ->references('id') 
                  ->on('users')
                  ->onDelete('cascade');
            
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('resolve_id') // Define the foreign key
                  ->references('id') 
                  ->on('resolve')
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
