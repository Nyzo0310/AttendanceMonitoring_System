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
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id('cash_advance_id');
            // Remove the foreign key constraint below
            $table->unsignedBigInteger('employee_id'); // Remove the foreignId line
            $table->date('request_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['approved', 'pending', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash__advance_tables');
    }
};
