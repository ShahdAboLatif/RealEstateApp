<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors_tasks_tracker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('unit_id');
            $table->date('task_submission_date');
            $table->text('assigned_tasks')->nullable();
            $table->date('any_scheduled_visits')->nullable();
            $table->text('notes')->nullable();
            $table->date('task_ending_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->nullable();
            $table->enum('urgent', ['yes', 'no'])->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraints
            // $table->foreign('city_id')->references('id')->on('cities')->onUpdate('no action')->onDelete('no action');
            $table->foreign('vendor_id')->references('id')->on('vendors_info')->onUpdate('no action')->onDelete('no action');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            // $table->index('city_id');
            $table->index('vendor_id');
            $table->index('unit_id');
            $table->index('task_submission_date');
            $table->index('status');
            $table->index('urgent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors_tasks_tracker');
    }
};
