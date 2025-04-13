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
        Schema::table('desconto', function (Blueprint $table) {
            $table->unsignedBigInteger('administradora_id')->nullable()->after('plano_id');

            // Define a foreign key
            $table->foreign('administradora_id')
                ->references('id')
                ->on('administradoras')
                ->onDelete('cascade'); // ou 'set null', dependendo da sua regra
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desconto', function (Blueprint $table) {
            $table->dropForeign(['administradora_id']);
            $table->dropColumn('administradora_id');
        });
    }
};
