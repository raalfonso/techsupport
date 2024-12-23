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
        Schema::create('mains', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();

            
        });

       
        DB::table('mains')->insert([
            ['id' => 1, 'title' => 'Setup'],
            ['id' => 2, 'title' => 'Acumatica'],
            ['id' => 3, 'title' => 'Security'],
            ['id' => 4, 'title' => 'Printer'],
            ['id' => 5, 'title' => 'Repair'],
            ['id' => 6, 'title' => 'Others'],
            
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mains');
    }
};
