<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('login_email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->boolean('sensitive_communication')->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
