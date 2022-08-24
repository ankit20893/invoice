<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enterprise_id');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->string('gr_no');
            $table->date('date');
            $table->string('bill_no');
            $table->string('from');
            $table->string('to');
            $table->string('truck_no');
            $table->string('driver_name');
            $table->unsignedBigInteger('consigner_id');
            $table->foreign('consigner_id')->references('id')->on('other_enterprises')->onDelete('cascade');
            $table->unsignedBigInteger('consignee_id');
            $table->foreign('consignee_id')->references('id')->on('other_enterprises')->onDelete('cascade');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id')->references('id')->on('other_enterprises');
            $table->string('no_of_packets');
            $table->string('hsv_sac_code');
            $table->string('description');
            $table->string('to_pay')->nullable();
            $table->string('weight');
            $table->string('rate');
            $table->string('value_of_goods');
            $table->boolean('is_gst')->default(false);
            $table->boolean('igst')->nullable();
            $table->string('gst_percentage')->nullable();
            $table->string('advance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
