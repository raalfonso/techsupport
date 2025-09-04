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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('acronym');
            $table->timestamps();
        });

          // Insert default departments with acronyms
          DB::table('departments')->insert([
            ['id' => 1, 'title' => 'Accounting and Comptrollership Department', 'acronym' => 'ACD'],
            ['id' => 2, 'title' => 'Business Development Department', 'acronym' => 'BDD'],
            ['id' => 3, 'title' => 'Budget Revenue Allocation Department', 'acronym' => 'BRAD'],
            ['id' => 4, 'title' => 'Board Secretariat', 'acronym' => 'BS'],
            ['id' => 5, 'title' => 'Corporate Planning Department', 'acronym' => 'CPD'],
            ['id' => 6, 'title' => 'Office of the Chairman', 'acronym' => 'OC'],
            ['id' => 7, 'title' => 'Engineering and Social Support Department', 'acronym' => 'ESSD'],
            ['id' => 8, 'title' => 'Engineering and Social Support Department - Clark', 'acronym' => 'ESSD-CLARK'],
            ['id' => 9, 'title' => 'Office of the Executive Vice President', 'acronym' => 'OEVP'],
            ['id' => 10, 'title' => 'Human Resource Management Department', 'acronym' => 'HRMD'],
            ['id' => 11, 'title' => 'Internal Audit Services Department', 'acronym' => 'IASD'],
            ['id' => 12, 'title' => 'Information and Communications Technology Department', 'acronym' => 'ICTD'],
            ['id' => 13, 'title' => 'ICTD - Information Technology Division', 'acronym' => 'ICTD-ITD'],
            ['id' => 14, 'title' => 'ICTD - Information Technology Division Clark', 'acronym' => 'ICTD-IT-CLARK'],
            ['id' => 15, 'title' => 'ICTD - Records Administration Division', 'acronym' => 'ICTD-RAD'],
            ['id' => 16, 'title' => 'ICTD - Records Administration Division Clark', 'acronym' => 'ICTD-RAD-CLARK'],
            ['id' => 17, 'title' => 'Investment Promotions and Marketing Department', 'acronym' => 'IPMD'],
            ['id' => 18, 'title' => 'Land and Assets Development Department', 'acronym' => 'LADD'], 
            ['id' => 19, 'title' => 'Legal Services Department', 'acronym' => 'LSD'],
            ['id' => 20, 'title' => 'Office of the President and CEO', 'acronym' => 'OPCEO'],
            ['id' => 21, 'title' => 'Conversion and Development Group', 'acronym' => 'CDG'],
            ['id' => 22, 'title' => 'Engineering and Social Support Department - BTP', 'acronym' => 'ESSD-BTP'],
            ['id' => 23, 'title' => 'Corporate Services Group', 'acronym' => 'CSG'],
            ['id' => 24, 'title' => 'Legal Services Group', 'acronym' => 'LSG'],
            ['id' => 25, 'title' => 'Investment and Financial Management Group', 'acronym' => 'IFMG'],
            ['id' => 26, 'title' => 'Public Affairs Department', 'acronym' => 'PAD'],
            ['id' => 27, 'title' => 'PPMD - Property Division', 'acronym' => 'PPMD-PROPERTY'],
            ['id' => 28, 'title' => 'Property and Procurement Management Department', 'acronym' => 'PPMD'],
            ['id' => 29, 'title' => 'PPMD - Bids And Awards Committee Division', 'acronym' => 'PPMD-BAC'],
            ['id' => 30, 'title' => 'PPMD - Procurement Division', 'acronym' => 'PPMD-PROCUREMENT'],
            ['id' => 31, 'title' => 'PPMD - General Services Division', 'acronym' => 'PPMD-GSD'],
            ['id' => 32, 'title' => 'Regulatory, Compliance and Risk Management Department', 'acronym' => 'RCRMD'],
            ['id' => 33, 'title' => 'Subsidiaries, Affiliates and Projects Monitoring Department', 'acronym' => 'SAPMD'],
            ['id' => 34, 'title' => 'Subic Clark Railway Project (SCRP)', 'acronym' => 'SCRP'],
            ['id' => 35, 'title' => 'Strategic Projects Management Department', 'acronym' => 'SPMD'],
            ['id' => 36, 'title' => 'Treasury and Project Finance Department', 'acronym' => 'TPFD'],
            ['id' => 37, 'title' => 'Security Management Department', 'acronym' => 'SMD'],
        
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
