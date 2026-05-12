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
        Schema::table('it_surveys', function (Blueprint $table) {
            $table->string('answer_question_5', 255)->nullable()->after('answer_question_4');
            $table->string('other_issues', 255)->nullable()->after('issues_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('it_surveys', function (Blueprint $table) {
            $table->dropColumn('answer_question_5');
            $table->dropColumn('other_issues');
        });
    }
};
