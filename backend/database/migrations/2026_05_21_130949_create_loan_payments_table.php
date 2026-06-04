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
        Schema::create('loan_payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('loan_id')

                ->constrained()

                ->cascadeOnDelete();

            $table->date('payment_month');

            $table->date('due_date');

            $table->decimal(
                'amount',
                12,
                2
            );

            $table->boolean('is_paid')

                ->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
