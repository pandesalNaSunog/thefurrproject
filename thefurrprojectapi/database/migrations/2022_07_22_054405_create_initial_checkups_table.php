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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('pet_id')->nullable();
            $table->string('pet_weight')->nullable();
            $table->string('temp')->nullable();
            $table->string('hr')->nullable();
            $table->string('rr')->nullable();
            $table->string('tests')->nullable();
            $table->string('procedure')->nullable();
            $table->string('medication')->nullable();
            $table->string('case_closed')->nullable();
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
