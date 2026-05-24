<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('travel_packages')) {
            Schema::create('travel_packages', function (Blueprint $table) {
                $table->id('package_id');
                $table->string('title');
                $table->text('description');
                $table->string('destination_city');
                $table->string('destination_country');
                $table->unsignedInteger('duration_days');
                $table->decimal('price_per_person', 10, 2);
                $table->unsignedInteger('max_capacity');
                $table->boolean('is_active')->default(true);
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_packages');
    }
};