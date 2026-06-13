<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyas', function (Blueprint $table) {
            $table->index('status_validasi');
            $table->index('kategori');
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyas', function (Blueprint $table) {
            $table->dropIndex(['status_validasi']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['tahun']);
        });
    }
};
