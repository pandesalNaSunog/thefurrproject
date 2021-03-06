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
        Schema::create('initial_checkups', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('wellness_behavior')->nullable();
            $table->string('pet_id')->nullable();
            $table->string('pet_weight')->nullable();
            $table->string('temp')->nullable();
            $table->string('hr')->nullable();
            $table->string('rr')->nullable();
            $table->string('physical_exam')->nullable();
            $table->string('cc_hx')->nullable();
            $table->string('dx_tools')->nullable();
            $table->string('tdx_dx_case')->nullable();
            $table->string('treatment')->nullable();
            $table->string('in_patient')->nullable();
            $table->string('surgery')->nullable();
            $table->string('out_patient')->nullable();
            $table->string('take_home_meds')->nullable();
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
        Schema::dropIfExists('initial_checkups');
    }
};
