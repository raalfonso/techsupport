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
        Schema::create('user_survey', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('password');
            $table->unsignedBigInteger('department_id');
            $table->string('status')->default('active');
            $table->string('role')->default('user');
            $table->timestamps();
        });

        Schema::create('survey_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('department_id');
            $table->string('status')->default('active');
            $table->unsignedBigInteger('user_survey_id');
            $table->timestamps();
        });

         Schema::table('user_survey', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
        Schema::table('survey_employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('user_survey_id')->references('id')->on('user_survey')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_survey');
        Schema::dropIfExists('survey_employees');
   
    }
};
