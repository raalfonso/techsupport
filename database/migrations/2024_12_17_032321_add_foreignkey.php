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
        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('department_id') // Define the foreign key
                  ->references('id') 
                  ->on('departments')
                  ->onDelete('cascade');
            $table->foreign('issues_id') // Define the foreign key
                  ->references('id') 
                  ->on('issues')
                  ->onDelete('cascade');
            // $table->foreign('category_id') // Define the foreign key
            //       ->references('id') 
            //       ->on('categories')
            //       ->onDelete('cascade');
            $table->foreign('response_by') // Define the foreign key
                  ->references('id') 
                  ->on('users')
                  ->onDelete('cascade');
            // $table->foreign('resolve_by') // Define the foreign key
            //       ->references('id') 
            //       ->on('users')
            //       ->onDelete('cascade');
            $table->foreign('escalated_to') // Define the foreign key
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
        Schema::table('report', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key
            $table->dropForeign(['department_id']);
            $table->dropForeign(['issues_id']);
            $table->dropForeign(['category_id']);
        });
    }
};
