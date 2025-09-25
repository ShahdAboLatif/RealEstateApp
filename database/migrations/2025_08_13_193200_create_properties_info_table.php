<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->string('name');
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('city_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
