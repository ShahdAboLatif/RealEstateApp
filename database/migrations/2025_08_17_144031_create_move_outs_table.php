<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('move_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->date('move_out_date');
            $table->enum('lease_status', ['ended', 'active']);
            $table->date('date_lease_ending_on_buildium')->nullable();
            $table->text('keys_location')->nullable();
            $table->string('utilities_under_our_name')->nullable();
            $table->date('date_utility_put_under_our_name')->nullable();
            $table->text('walkthrough')->nullable();
            $table->text('repairs')->nullable();
            $table->enum('send_back_security_deposit', ['yes', 'no', 'partly'])->nullable();
            $table->text('notes')->nullable();
            $table->enum('cleaning', ['cleaned', 'uncleaned'])->nullable();
            $table->boolean('list_the_unit')->nullable();
            $table->enum('move_out_form', ['filled', 'not filled'])->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('move_out_date');
            $table->index('lease_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('move_outs');
    }
};
