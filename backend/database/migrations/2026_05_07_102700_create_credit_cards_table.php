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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('card_last_four', 4);
            $table->string('card_image')->nullable();
            $table->decimal('credit_limit', 10, 2);
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('minimum_due', 10, 2)->nullable();
            $table->integer('billing_day')->nullable();
            $table->integer('due_day')->nullable();
            $table->date('start_date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
