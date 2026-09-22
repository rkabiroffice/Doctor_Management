<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('format');
            $table->string('file_path')->nullable();
            $table->string('original_name')->nullable();
            $table->string('status')->default('queued');
            $table->unsignedInteger('processed')->default(0);
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_transfers');
    }
};
