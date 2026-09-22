<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('medicines', 'notes')) {
            Schema::table('medicines', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('manufacturer');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('medicines', 'notes')) {
            Schema::table('medicines', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};