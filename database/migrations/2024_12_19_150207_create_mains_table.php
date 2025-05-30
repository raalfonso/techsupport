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
            $table->string('details');
            $table->timestamps();

            
        });

       
        DB::table('mains')->insert([
            ['id' => 1, 'title' => 'Video Conferencing/Meeting Support', 'details' => 'Provision of technical and configuration support, along with other related concerns pertaining to video conferencing or meeting platforms.'],
            ['id' => 2, 'title' => 'Acumatica ERP, HRIS, AODocs, Google WorkSpace', 'details' => 'Support for Acumatica, HRIS, Google Work Space related issues'],
            ['id' => 3, 'title' => 'Cyber Security,', 'details' => 'Support for malware, phishing, and other cybersecurity issues.'],
            ['id' => 4, 'title' => 'Hardware, Network and Software','details'=>'Support for hardware and software malfunctions, connectivity, printer, and network issues'],
            ['id' => 99, 'title' => 'Others', 'details' => 'Assistance for technical concerns not covered in other categories'],
            
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
