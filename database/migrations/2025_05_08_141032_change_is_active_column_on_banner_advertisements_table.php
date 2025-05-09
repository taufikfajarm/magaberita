<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banner_advertisements', function (Blueprint $table) {
            // Ubah kolom enum ke boolean
            $table->boolean('is_active')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('banner_advertisements', function (Blueprint $table) {
            // Balik lagi ke enum jika dibutuhkan rollback
            $table->enum('is_active', ['active', 'not_active'])->default('not_active')->change();
        });
    }
};
