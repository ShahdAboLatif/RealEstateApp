<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->string('name', 100)->nullable();
            $table->string('co_signer', 100)->nullable();
            $table->enum('status', ['undecieded', 'approved', 'rejected', 'in_review'])->nullable();
            $table->date('date')->nullable();
            $table->string('stage_in_progress', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment_name', 255)->nullable();
            $table->string('attachment_path', 500)->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('status');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
