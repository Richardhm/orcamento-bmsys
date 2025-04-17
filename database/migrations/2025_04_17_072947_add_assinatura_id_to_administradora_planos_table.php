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
        Schema::table('administradora_planos', function (Blueprint $table) {
            $table->unsignedBigInteger('assinatura_id')->nullable()->after('tabela_origens_id');
            $table->foreign('assinatura_id')->references('id')->on('assinaturas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administradora_planos', function (Blueprint $table) {
            $table->dropForeign(['assinatura_id']);
            $table->dropColumn('assinatura_id');
        });
    }
};
