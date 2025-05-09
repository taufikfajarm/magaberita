<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE banner_advertisements MODIFY is_active ENUM('active', 'not_active') NOT NULL DEFAULT 'not_active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE banner_advertisements MODIFY is_active TINYINT(1) DEFAULT 0");
    }
};

