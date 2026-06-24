<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parques', function (Blueprint $table) {
            $table->decimal('comissao_percentual', 5, 2)->default(0.00);
            $table->decimal('comissao_fixa', 8, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parques', function (Blueprint $table) {
            $table->dropColumn(['comissao_percentual', 'comissao_fixa']);
        });
    }
};
