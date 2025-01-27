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
        Schema::table('emails_assinatura', function (Blueprint $table) {
            $table->boolean('is_administrador')->default(false)->after('email'); // Adiciona o campo após 'email'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails_assinatura', function (Blueprint $table) {
            $table->dropColumn('is_administrador');
        });
    }
};
