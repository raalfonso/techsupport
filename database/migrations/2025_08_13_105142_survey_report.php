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
        Schema::create('survey_report', function (Blueprint $table) {
            $table->id();
            $table->date('survey_date');
            $table->unsignedBigInteger('survey_employees_id');
            $table->integer('accuracy_of_service');
            $table->integer('response_time');
            $table->text('comments')->nullable();
            $table->string('client_name')->nullable();
            $table->timestamps();
            $table->foreign('survey_employees_id')->references('id')->on('survey_employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('survey_report');
    }
};
