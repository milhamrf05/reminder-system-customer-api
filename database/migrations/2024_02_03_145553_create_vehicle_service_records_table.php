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
        Schema::create('vehicle_service_records', function (Blueprint $table) {
            $table->id();
            $table->string('chassis_number');
            $table->string('license_plate_number');
            $table->unsignedBigInteger('interval_to_now_id');
            $table->foreign('interval_to_now_id')->references('id')->on('interval_to_now')->onDelete('cascade');
            $table->dateTime('last_service')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone_number');
            $table->string('vehicle_model');
            $table->date('delivery_date');
            $table->string('service_advisor_name');
            $table->string('program_name');
            $table->string('sales_branch');
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
        Schema::dropIfExists('vehicle_service_records');
    }
};
