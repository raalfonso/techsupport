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
         Schema::table('dev_watches', function (Blueprint $table) {
            $table->enum('type', ['Bugs', 'Improvement','New Feature'])->default('Bugs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dev_watches', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
