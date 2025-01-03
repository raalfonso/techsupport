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

        DB::table('categories')->insert([
            ['id' => 1, 'title' => 'Low', 'timeline' => '10'],
            ['id' => 2, 'title' => 'Medium', 'timeline' => '30'],
            ['id' => 3, 'title' => 'High', 'timeline' => '60'],
        ]);

        DB::table('issues')->insert([
            ['id' => 1, 'category_id' => '1', 'title' => 'Setup boardroom', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 2, 'category_id' => '1', 'title' => 'Setup Conference room A', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 3, 'category_id' => '1', 'title' => 'Setup Conference room B', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 4, 'category_id' => '1', 'title' => 'Setup Conference room C', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 5, 'category_id' => '1', 'title' => 'Setup Conference room D', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 17, 'category_id' => '1', 'title' => 'Setup Zoom meeting', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 18, 'category_id' => '1', 'title' => 'Setup Google meet', 'mains_id' => '1', 'type' => 'request'],
            ['id' => 19, 'category_id' => '1', 'title' => 'Others', 'mains_id' => '1', 'type' => 'request'],

            // system account 
            ['id' => 6, 'category_id' => '1', 'title' => 'Acumatica forgot password', 'mains_id' => '2', 'type' => 'request'],
            ['id' => 7, 'category_id' => '1', 'title' => 'Acumatica unlock account', 'mains_id' => '2', 'type' => 'request'],
            ['id' => 8, 'category_id' => '1', 'title' => 'Govmail forgot password', 'mains_id' => '2', 'type' => 'request'],
            ['id' => 9, 'category_id' => '1', 'title' => 'HRIS forgot password', 'mains_id' => '2', 'type' => 'request'],
            ['id' => 20, 'category_id' => '1', 'title' => 'Others', 'mains_id' => '2', 'type' => 'request'],

         
            //security
            ['id' => 10, 'category_id' => '3', 'title' => 'Malware detection', 'mains_id' => '3', 'type' => 'report'],
            ['id' => 11, 'category_id' => '3', 'title' => 'Phishing detection', 'mains_id' => '3', 'type' => 'report'],
            ['id' => 21, 'category_id' => '3', 'title' => 'Others', 'mains_id' => '3', 'type' => 'report'],


            //printer
            ['id' => 12, 'category_id' => '1', 'title' => 'Printing issue', 'mains_id' => '4', 'type' => 'report'],
            ['id' => 13, 'category_id' => '1', 'title' => 'Paper jam', 'mains_id' => '4', 'type' => 'report'],
            ['id' => 14, 'category_id' => '1', 'title' => 'Offline', 'mains_id' => '4', 'type' => 'report'],
            ['id' => 15, 'category_id' => '1', 'title' => 'Scanning issue', 'mains_id' => '4', 'type' => 'report'],
            ['id' => 16, 'category_id' => '1', 'title' => 'Replace cartridge toner', 'mains_id' => '4', 'type' => 'report'],
            ['id' => 22, 'category_id' => '1', 'title' => 'Others', 'mains_id' => '4', 'type' => 'report'],
            
            //software and hardware
            ['id' => 23, 'category_id' => '3', 'title' => 'Hardware issue', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 24, 'category_id' => '3', 'title' => 'Software issue', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 25, 'category_id' => '3', 'title' => 'File recovery/Backup', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 26, 'category_id' => '2', 'title' => 'Slow performance', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 27, 'category_id' => '2', 'title' => 'IP Phone issue', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 28, 'category_id' => '2', 'title' => 'Software installation/Update', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 29, 'category_id' => '2', 'title' => 'Cant connect to wifi', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 30, 'category_id' => '2', 'title' => 'Slow internet connection', 'mains_id' => '5', 'type' => 'report'],
            ['id' => 31, 'category_id' => '2', 'title' => 'Others', 'mains_id' => '5', 'type' => 'report'],


        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
