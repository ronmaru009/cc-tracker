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
        Schema::table('credit_card_records', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('minimum_due');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_card_records', function (Blueprint $table) {
            $table->dropColumn('due_date');
        });
    }
};
