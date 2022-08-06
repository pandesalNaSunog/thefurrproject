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
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('pet_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('lab_tech_id')->nullable();
            $table->string('request')->nullable();
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
        Schema::dropIfExists('lab_requests');
    }
};
