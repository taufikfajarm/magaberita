<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('article_news', function (Blueprint $table) {
            $table->renameColumn('id_featured', 'is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('article_news', function (Blueprint $table) {
            $table->renameColumn('is_featured', 'id_featured');
        });
    }
};
