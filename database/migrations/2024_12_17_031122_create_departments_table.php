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
            ['id' => 1, 'title' => 'Office of the President and CEO', 'acronym' => 'OPCEO'],
            ['id' => 2, 'title' => 'Office of the Chairman', 'acronym' => 'OOC'],
            ['id' => 3, 'title' => 'Office of the Corporate Secretary', 'acronym' => 'OOCS'],
            ['id' => 4, 'title' => 'Office of the Internal Auditor', 'acronym' => 'OIA'],
            ['id' => 5, 'title' => 'Office of the General Counsel', 'acronym' => 'OGC'],
            ['id' => 6, 'title' => 'Corporate Planning Office', 'acronym' => 'CPO'],
            ['id' => 7, 'title' => 'Corporate Communications Office', 'acronym' => 'CCO'],
            ['id' => 8, 'title' => 'Project Management Office (New Clark City)', 'acronym' => 'PMO-NCC'],
            ['id' => 9, 'title' => 'Business Development Department', 'acronym' => 'BDD'],
            ['id' => 10, 'title' => 'Investment Promotions and Marketing Department', 'acronym' => 'IPMD'],
            ['id' => 11, 'title' => 'Land and Assets Development Department', 'acronym' => 'LADD'],
            ['id' => 12, 'title' => 'Project Management Department', 'acronym' => 'PMD'],
            ['id' => 13, 'title' => 'Accounting and Comptrollership Department', 'acronym' => 'ACD'],
            ['id' => 14, 'title' => 'Budget Revenue Allocation Department', 'acronym' => 'BRAD'],
            ['id' => 15, 'title' => 'Treasury and Project Finance Department', 'acronym' => 'TPFD'],
            ['id' => 16, 'title' => 'Investment Management Department', 'acronym' => 'IMD'],
            ['id' => 17, 'title' => 'Organization Development and Management Department', 'acronym' => 'ODMD'],
            ['id' => 18, 'title' => 'Property and Procurement Management Department', 'acronym' => 'PPMD'],
            ['id' => 19, 'title' => 'Information Services Department', 'acronym' => 'ISD'],
            ['id' => 20, 'title' => 'Security Services Department', 'acronym' => 'SSD'],
            ['id' => 21, 'title' => 'Office of the Executive Vice President', 'acronym' => 'OEVP'],
            ['id' => 22, 'title' => 'General Services Department', 'acronym' => 'GSD'],
            ['id' => 23, 'title' => 'Project Management Office (SCTEX)', 'acronym' => 'PMO-SCTEX'],
            ['id' => 24, 'title' => 'Commission on Audit (COA)', 'acronym' => 'COA'],
            ['id' => 25, 'title' => 'Bataan Technology Park (BTP)', 'acronym' => 'BTP'],
            ['id' => 26, 'title' => 'John Hay Management Corporation (JHMC)', 'acronym' => 'JHMC'],
            ['id' => 27, 'title' => 'Poro Point Management Corporation (PPMC)', 'acronym' => 'PPMC'],
            ['id' => 28, 'title' => 'Business Development Department - Clark', 'acronym' => 'BDD-Clark'],
            ['id' => 29, 'title' => 'General Services Department - Clark', 'acronym' => 'GSD-Clark'],
            ['id' => 30, 'title' => 'Information Services Department - Clark', 'acronym' => 'ISD-Clark'],
            ['id' => 31, 'title' => 'Land and Assets Development Department - Clark', 'acronym' => 'LADD-Clark'],
            ['id' => 32, 'title' => 'Organization Development and Management Department - Clark', 'acronym' => 'ODMD-Clark'],
            ['id' => 33, 'title' => 'Project Management Department - Clark', 'acronym' => 'PMD-Clark'],
            ['id' => 34, 'title' => 'Security Services Department - Clark', 'acronym' => 'SSD-Clark'],
            ['id' => 35, 'title' => 'Accounting Department - Clark', 'acronym' => 'ACD-Clark'],
            ['id' => 36, 'title' => 'Property and Procurement Management Department - Clark', 'acronym' => 'PPMD-Clark'],
            ['id' => 37, 'title' => 'Director', 'acronym' => 'DIR'],
            ['id' => 38, 'title' => 'Records Management and Office Services Division (RMOSD)', 'acronym' => 'RMOSD'],
            ['id' => 39, 'title' => 'Subic Clark Railway Project (SCRP)', 'acronym' => 'SCRP'],
            ['id' => 40, 'title' => 'Office of the President and CEO - Clark', 'acronym' => 'OPCEO-Clark'],
            ['id' => 41, 'title' => 'Board Secretariat', 'acronym' => 'BS'],
            ['id' => 42, 'title' => 'Internal Audit Services Department', 'acronym' => 'IASD'],
            ['id' => 43, 'title' => 'Public Affairs Department', 'acronym' => 'PAD'],
            ['id' => 44, 'title' => 'Corporate Planning Department', 'acronym' => 'CPD'],
            ['id' => 45, 'title' => 'OSVP - Investment and Financial Management Group', 'acronym' => 'OSVP-IFMG'],
            ['id' => 46, 'title' => 'Accounting and Comptrollership Department', 'acronym' => 'ACD'],
            ['id' => 47, 'title' => 'Budget and Revenue Allocation Department', 'acronym' => 'BRAD'],
            ['id' => 48, 'title' => 'Treasury and Project Finance Department', 'acronym' => 'TPFD'],
            ['id' => 49, 'title' => 'Subsidiaries, Affiliates and Projects Monitoring Department', 'acronym' => 'SAPMD'],
            ['id' => 50, 'title' => 'OSVP - Corporate Services Group', 'acronym' => 'OSVP-CSG'],
            ['id' => 51, 'title' => 'Human Resource Management Department', 'acronym' => 'HRMD'],
            ['id' => 52, 'title' => 'Information and Communications Technology Department', 'acronym' => 'ICTD'],
            ['id' => 53, 'title' => 'Security Management Department', 'acronym' => 'SMD'],
            ['id' => 54, 'title' => 'OSVP - Legal Services Group', 'acronym' => 'OSVP-LSG'],
            ['id' => 55, 'title' => 'Legal Services Department', 'acronym' => 'LSD'],
            ['id' => 56, 'title' => 'Regulatory, Compliance and Risk Management Department', 'acronym' => 'RCRMD'],
            ['id' => 57, 'title' => 'OSVP - Conversion and Development Group', 'acronym' => 'OSVP-CDG'],
            ['id' => 58, 'title' => 'Engineering and Social Support Department', 'acronym' => 'ESSD'],
            ['id' => 59, 'title' => 'Strategic Projects Management Department', 'acronym' => 'SPMD'],
            ['id' => 60, 'title' => 'Information and Communications Technology Department - Clark', 'acronym' => 'ICTD-Clark'],
            ['id' => 61, 'title' => 'Human Resource Management Department - Clark', 'acronym' => 'HRMD-Clark'],
            ['id' => 62, 'title' => 'ESSD - Engineering', 'acronym' => 'ESSD-ENG'],
            ['id' => 63, 'title' => 'Security Management Department - Clark', 'acronym' => 'SMD-Clark'],
            ['id' => 64, 'title' => 'Accounting and Comptrollership Department - Clark', 'acronym' => 'ACD-Clark'],
            ['id' => 65, 'title' => 'COVID-19 Volunteers', 'acronym' => 'COVID-19 Vol'],
            ['id' => 66, 'title' => 'ESSD - Social Support', 'acronym' => 'ESSD-SS'],
            ['id' => 67, 'title' => 'PPMD - General Services', 'acronym' => 'PPMD-GS'],
            ['id' => 68, 'title' => 'Treasury and Project Finance Department - Clark', 'acronym' => 'TPFD-Clark'],
            ['id' => 69, 'title' => 'PPMD - Property Management', 'acronym' => 'PPMD-PM'],
            ['id' => 70, 'title' => 'PPMD - General Services - Clark', 'acronym' => 'PPMD-GS-Clark'],
            ['id' => 71, 'title' => 'ICTD - Information Technology', 'acronym' => 'ICTD-IT'],
            ['id' => 72, 'title' => 'ICTD - Information Technology - Clark', 'acronym' => 'ICTD-IT-Clark'],
            ['id' => 73, 'title' => 'ICTD - Records Administration', 'acronym' => 'ICTD-RA'],
            ['id' => 74, 'title' => 'ICTD - Records Administration - Clark', 'acronym' => 'ICTD-RA-Clark'],
            ['id' => 75, 'title' => 'Investment Promotions and Marketing Department - Clark', 'acronym' => 'IPMD-Clark'],
            ['id' => 76, 'title' => 'ESSD - Engineering - BTP', 'acronym' => 'ESSD-ENG-BTP'],
            ['id' => 77, 'title' => 'Strategic Projects Management Department - BTP', 'acronym' => 'SPMD-BTP'],
            ['id' => 78, 'title' => 'PPMD - General Services - BTP', 'acronym' => 'PPMD-GS-BTP'],
            ['id' => 79, 'title' => 'Strategic Projects Management Department - Taguig', 'acronym' => 'SPMD-Taguig'],
            ['id' => 80, 'title' => 'Public Affairs Department - Clark', 'acronym' => 'PAD-Clark'],
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
