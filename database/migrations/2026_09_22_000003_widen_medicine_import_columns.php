<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE medicines MODIFY strength LONGTEXT NULL');
        DB::statement('ALTER TABLE medicines MODIFY dosage_form LONGTEXT NULL');
        DB::statement('ALTER TABLE medicines MODIFY manufacturer LONGTEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE medicines MODIFY strength VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medicines MODIFY dosage_form VARCHAR(255) NULL');
        DB::statement('ALTER TABLE medicines MODIFY manufacturer VARCHAR(255) NULL');
    }
};