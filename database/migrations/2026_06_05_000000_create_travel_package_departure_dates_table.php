<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_package_departure_dates', function (Blueprint $table) {
            $table->id('departure_date_id');
            $table->foreignId('package_id')->constrained('travel_packages', 'package_id')->cascadeOnDelete();
            $table->date('departure_date');
        });

        if (Schema::hasTable('travel_packages')) {
            $packages = DB::table('travel_packages')
                ->whereNotNull('departure_date')
                ->get();

            foreach ($packages as $package) {
                DB::table('travel_package_departure_dates')->insert([
                    'package_id' => $package->package_id,
                    'departure_date' => $package->departure_date,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_package_departure_dates');
    }
};
