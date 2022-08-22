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
            $table->string('no_of_packets');
            $table->string('hsv_sac_code');
            $table->string('description');
            $table->string('weight');
            $table->string('rate');
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
