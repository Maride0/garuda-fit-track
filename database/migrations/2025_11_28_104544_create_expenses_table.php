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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expenses_code');
            $table->date('expense_date');
            $table->string('applicant_name');
            $table->enum('type', [
                'latihan', 
                'peralatan',
                'kesehatan',
                'kompetisi',
                'akomodasi',
                'lainnya',
            ]); 
            $table->decimal('amount', 15, 0);
            $table->string('description');
            $table->enum('status', [
                'paid',
                'reimbursed',
            ])->default('paid');
            // bukti transaksi
            $table->string('receipt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
