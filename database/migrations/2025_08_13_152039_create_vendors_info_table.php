<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->string('vendor_name', 100);
            $table->string('number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('service_type', 50)->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('city_id');
            $table->index('vendor_name');
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors_info');
    }
};
