<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_insurance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('insurance_company_name');
            $table->decimal('amount', 15, 2);
            $table->string('policy_number');
            $table->date('effective_date');
            $table->date('expiration_date');
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('property_id');
            $table->index('expiration_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_insurance');
    }
};
