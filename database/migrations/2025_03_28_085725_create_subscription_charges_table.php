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
        Schema::create('subscription_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id');
            $table->integer('charge_id')->unique();
            $table->decimal('value', 10, 2);
            $table->string('status');
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('event_date');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index('subscription_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_charges');
    }
};
