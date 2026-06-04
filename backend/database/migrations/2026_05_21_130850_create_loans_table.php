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
        Schema::create('loans', function (Blueprint $table) {

            $table->id();

            $table->string('loan_name');

            $table->decimal(
                'total_amount',
                12,
                2
            );

            $table->date('start_date');

            $table->date('end_date');

            $table->integer('due_day');

            $table->decimal(
                'monthly_amortization',
                12,
                2
            );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
