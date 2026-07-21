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
        Schema::table('projects', function (Blueprint $table) {
        $table->enum('status', [
            'active',
            'Requested',
            'Pending',
            'For Evaluation',
            'Data Gathering',
            'On Hold',
            'Development',
            'Testing',
            'User Acceptance Training',
            'Deployed',
            'For Enhancement'
        ])->default('Requested')->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'completed', 'on_hold'])->default('active')->change();
        });
    }
};
