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
        Schema::create('confinements', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_id');
            $table->string('type_of_fluid');
            $table->string('drip_rate');
            $table->string('duration_of_fluid_per_day');
            $table->string('temp_def_diagnosis');
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
        Schema::dropIfExists('confinements');
    }
};
