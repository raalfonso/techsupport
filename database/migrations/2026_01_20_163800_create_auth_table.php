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
        Schema::create('auth_item', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('rule_name')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();
        });

        Schema::create('auth_item_child', function (Blueprint $table) {
            $table->id();
            $table->string('parent');
            $table->string('child');
            $table->foreign('parent')->references('name')->on('auth_item')->onDelete('cascade');
            $table->foreign('child')->references('name')->on('auth_item')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('auth_assignment', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('item_name')->references('name')->on('auth_item')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_item_child');
        Schema::dropIfExists('auth_assignment');
        Schema::dropIfExists('auth_item');
        
    }
};
