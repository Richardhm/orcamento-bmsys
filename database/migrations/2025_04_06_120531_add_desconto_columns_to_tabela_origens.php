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
        Schema::table('tabela_origens', function (Blueprint $table) {
            $table->boolean('desconto')->nullable()->after('nome')->default(0);
            $table->integer('desconto_valor')->nullable()->after('desconto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabela_origens', function (Blueprint $table) {
            $table->dropColumn(['desconto_valor', 'desconto']);
        });
    }
};
