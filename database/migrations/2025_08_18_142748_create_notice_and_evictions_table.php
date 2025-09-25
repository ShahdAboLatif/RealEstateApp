<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notice_and_evictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('notice_id');
            $table->enum('status', ['pending', 'served', 'resolved', 'evicted']);
            $table->date('date');
            $table->boolean('have_an_exception')->nullable();
            $table->text('note')->nullable();
            // $table->enum('evictions', ['alert', 'has an exception'])->nullable();
            $table->enum('sent_to_attorney', ['yes', 'no'])->nullable();
            $table->date('hearing_dates')->nullable();
            $table->enum('evicted_or_payment_plan', ['evicted', 'payment plan', 'resolved'])->nullable();
            $table->enum('if_left', ['yes', 'no'])->nullable();
            $table->date('writ_date')->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');
            $table->foreign('notice_id')->references('id')->on('notices')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('notice_id');
            $table->index('status');
            $table->index('date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notice_and_evictions');
    }
};
