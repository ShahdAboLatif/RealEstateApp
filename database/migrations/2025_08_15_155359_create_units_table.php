<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('name');
            $table->string('street_address_line')->nullable();
            $table->decimal('count_beds', 8, 2)->nullable();
            $table->decimal('count_baths', 8, 2)->nullable();
            $table->decimal('monthly_rent', 15, 2)->nullable();
            $table->text('recurring_transaction')->nullable();
            $table->enum('utility_status', ['under our name', 'under owner name', 'under tenant name'])->nullable();
            $table->string('account_number')->nullable();
            $table->boolean('vacant')->nullable();
            $table->boolean('listed')->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('property_id');
            $table->index('vacant');
            $table->index('listed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
