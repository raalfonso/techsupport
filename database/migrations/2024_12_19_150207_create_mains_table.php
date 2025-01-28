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
            ['id' => 1, 'title' => 'Video Conferencing/Meeting Support'],
            ['id' => 2, 'title' => 'Acumatica ERP and HRIS'],
            ['id' => 3, 'title' => 'Security'],
            ['id' => 4, 'title' => 'Hardware'],
            ['id' => 5, 'title' => 'Network'],
            ['id' => 6, 'title' => 'AODocs'],
            ['id' => 7, 'title' => 'Software'],
            ['id' => 8, 'title' => 'G Suite/Google Workspace'],
            ['id' => 9, 'title' => 'Others'],
            
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
