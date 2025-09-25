<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->decimal('amount', 10, 2);
            $table->date('dates');
            $table->decimal('paid', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
