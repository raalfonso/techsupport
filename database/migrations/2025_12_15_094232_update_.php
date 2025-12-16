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
        DB::table('mains')
            ->whereIn('id', [2, 3,4,99])
            ->update([
                'type' => 'report',
                'updated_at' => now(),
            ]);

        DB::table('mains')
            ->where('id', 1)
            ->update([
                'type' => 'request',
                'updated_at' => now(),
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
