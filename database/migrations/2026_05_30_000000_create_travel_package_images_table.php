<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('travel_package_images')) {
            Schema::create('travel_package_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('package_id');
                $table->string('path');
                $table->timestamp('created_at')->nullable();

                $table->foreign('package_id')
                    ->references('package_id')
                    ->on('travel_packages')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_package_images');
    }
};
