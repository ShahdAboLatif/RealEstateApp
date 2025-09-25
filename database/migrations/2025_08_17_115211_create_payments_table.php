<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->date('date');
            $table->decimal('owes', 10, 2);
            $table->decimal('paid', 10, 2);

            $table->text('notes')->nullable();
            $table->decimal('reversed_payments', 10, 2)->nullable();
            $table->enum('permanent', ['yes', 'no']);
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
