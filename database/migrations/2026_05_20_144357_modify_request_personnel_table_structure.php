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
        Schema::table('request_personnel', function (Blueprint $table) {
            // Drop redundant columns
            $table->dropColumn(['title', 'resource_needed']);
            
            // Change point_person to varchar(100)
            $table->string('point_person')->default(false)->after('requestor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_personnel', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('title')->nullable();
            $table->text('resource_needed')->nullable();
            
            // Revert point_person back to original type if needed
            $table->dropColumn('point_person');
        });
    }
};
