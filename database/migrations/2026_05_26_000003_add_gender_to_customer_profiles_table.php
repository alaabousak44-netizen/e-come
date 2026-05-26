<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('customer_profiles')) {
            return;
        }

        Schema::table('customer_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('customer_profiles', 'gender')) {
                $table->string('gender')->nullable()->after('nationality');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('customer_profiles')) {
            return;
        }

        Schema::table('customer_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('customer_profiles', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};
