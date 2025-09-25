<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('move_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->boolean('signed_lease')->nullable();
            $table->date('lease_signing_date')->nullable();
            $table->enum('lease_status', ['Fixed','Fixed with roll over','At will']); // Note: ENUM values need to be specified
            $table->date('lease_start');
            $table->date('lease_end');
            $table->date('move_in_form_sent_date')->nullable();
            $table->boolean('filled_move_in_form')->nullable();
            $table->date('date_of_move_in_form_filled')->nullable();
            $table->boolean('handled_keys');
            $table->date('move_in_date')->nullable();
            $table->boolean('Has_paid_security_deposit_first_month_rent');
            $table->text('note_paid_security_deposit_first_month_rent')->nullable();
            $table->date('scheduled_paid_time')->nullable();
            $table->boolean('has_assistance')->nullable();
            $table->decimal('assistance_amount', 15, 2)->nullable();
            $table->string('assistance_company')->nullable();
            $table->boolean('has_insurance')->nullable();
            $table->enum('insurance_status', ['Expired', 'Active'])->nullable();
            $table->boolean('submitted_insurance')->nullable();
            $table->date('date_of_insurance_expiration')->nullable();
            $table->enum('cash_or_check', ['cash', 'check'])->nullable();
            $table->boolean('permanent')->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('lease_status');
            $table->index('move_in_date');
            $table->index('lease_signing_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('move_ins');
    }
};
