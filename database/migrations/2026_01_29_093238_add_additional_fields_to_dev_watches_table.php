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
        Schema::table('dev_watches', function (Blueprint $table) {
            $table->string('requestor_name')->nullable()->after('remarks');
            $table->date('reported_date')->nullable()->after('requestor_name');
            $table->date('start_date')->nullable()->after('reported_date');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dev_watches', function (Blueprint $table) {
            $table->dropColumn(['requestor_name', 'reported_date', 'start_date', 'end_date']);
        });
    }
};
