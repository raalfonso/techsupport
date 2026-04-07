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
        Schema::table('it_survey_issues', function (Blueprint $table) {
            $table->string('other_issues', 255)->nullable()->after('details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('it_survey_issues', function (Blueprint $table) {
            $table->dropColumn('other_issues');
        });
    }
};
