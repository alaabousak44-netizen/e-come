<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('travel_requests')) {
            Schema::create('travel_requests', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('destination_interest');
                $table->text('message');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};
