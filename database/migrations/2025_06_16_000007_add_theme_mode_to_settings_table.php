<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'theme_mode')) {
                $table->enum('theme_mode', ['light', 'dark', 'auto'])->default('light')->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'theme_mode')) {
                $table->dropColumn('theme_mode');
            }
        });
    }
};

