<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->date('departure_date')->nullable()->after('price_per_person');
        });

        DB::table('travel_packages')
            ->whereNull('departure_date')
            ->update(['departure_date' => now()->addWeeks(2)->toDateString()]);
    }

    public function down(): void
    {
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->dropColumn('departure_date');
        });
    }
};
