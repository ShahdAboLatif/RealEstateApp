<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offers_and_renewals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->date('date_sent_offer');
            $table->date('date_offer_expires')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'expired'])->nullable();
            $table->date('date_of_acceptance')->nullable();
            $table->date('last_notice_sent')->nullable();
            $table->integer('how_many_days_left_offer')->nullable();
            $table->string('notice_kind', 100)->nullable();
            $table->enum('lease_sent', ['yes', 'no'])->nullable();
            $table->date('date_sent_lease')->nullable();
            $table->date('date_lease_expires')->nullable();
            $table->enum('lease_signed', ['yes', 'no'])->nullable();
            $table->date('date_signed')->nullable();
            $table->date('last_notice_sent_2')->nullable();
            $table->string('notice_kind_2', 100)->nullable();
            $table->text('notes')->nullable();
            $table->integer('how_many_days_left_renewal')->nullable();
            $table->enum('expired', ['yes', 'no'])->nullable();
            $table->boolean('archived')->default(0)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('no action')->onDelete('no action');

            // Add indexes for better query performance
            $table->index('unit_id');
            $table->index('status');
            $table->index('date_sent_offer');
            $table->index('date_offer_expires');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers_and_renewals');
    }
};
