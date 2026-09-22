<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('generic_name')->nullable();
            $table->text('strength')->nullable();
            $table->text('dosage_form')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('ref of dcc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $foreignKey = DB::selectOne(
            'SELECT CONSTRAINT_NAME
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?
               AND REFERENCED_TABLE_NAME = ?
             LIMIT 1',
            [DB::getDatabaseName(), 'prescription_medicines', 'medicine_id', 'medicines']
        );

        if ($foreignKey?->CONSTRAINT_NAME) {
            Schema::table('prescription_medicines', function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey->CONSTRAINT_NAME);
            });
        }

        Schema::dropIfExists('medicines');
    }
};
