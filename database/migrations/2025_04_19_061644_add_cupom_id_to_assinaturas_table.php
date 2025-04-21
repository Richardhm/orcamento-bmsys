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
        Schema::table('assinaturas', function (Blueprint $table) {
            $table->unsignedBigInteger('cupom_id')->nullable()->after('user_id'); // Substitua 'alguma_coluna_existente' pela coluna existente após a qual a nova coluna deve ser adicionada
            // Define a chave estrangeira
            $table->foreign('cupom_id')->references('id')->on('cupons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assinaturas', function (Blueprint $table) {
            $table->dropForeign(['cupom_id']);
            $table->dropColumn('cupom_id');
        });
    }
};
