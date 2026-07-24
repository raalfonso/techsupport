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
        Schema::create('survey_generated', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_survey_id');
            $table->string('generated_code')->unique();
            $table->integer('count')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('usage_limit')->nullable();
            $table->string('client_name')->nullable();
            $table->timestamps();

            $table->foreign('user_survey_id')->references('id')->on('user_survey')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_generated');
    }
};
