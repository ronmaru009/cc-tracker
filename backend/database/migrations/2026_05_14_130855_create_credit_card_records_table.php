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
        Schema::create('credit_card_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_card_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('month');

            $table->decimal('balance', 10, 2);

            $table->decimal('minimum_due', 10, 2)
                ->nullable();

            $table->decimal('payment_amount', 10, 2)
                ->nullable();

            $table->date('payment_date')
                ->nullable();

            $table->integer('points_earned')
                ->default(0);

            $table->text('remarks')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_records');
    }
};
