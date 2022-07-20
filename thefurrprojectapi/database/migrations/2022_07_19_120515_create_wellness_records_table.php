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
        Schema::create('wellness_records', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_id');
            $table->integer('doctor_id');
            $table->string('service');
            $table->string('remarks');
            $table->date('date');
            $table->date('next_appointment');
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
        Schema::dropIfExists('wellness_records');
    }
};
