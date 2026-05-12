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

        Schema::create('it_survey_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('it_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issues_id')->constrained('it_survey_issues')->onDelete('cascade');
            $table->string('employee_number');
            $table->foreign('employee_number')->references('employee_number')->on('employee_masterlists')->onDelete('cascade');
            $table->string('answer_question_1')->nullable();
            $table->string('answer_question_2')->nullable();
            $table->string('answer_question_3')->nullable();
            $table->string('answer_question_4')->nullable();
            $table->text('suggestion')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_surveys');
        Schema::dropIfExists('it_survey_issues');
    }
};
