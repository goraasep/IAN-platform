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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type');
            $table->double('actual_value')->default(0);
            $table->string('unit')->nullable();
            $table->double('th_H')->default(0);
            $table->integer('th_H_enable')->default(0);
            $table->double('th_L')->default(0);
            $table->integer('th_L_enable')->default(0);
            $table->string('alert')->default('Normal');
            $table->string('alert_prev')->default('Normal');
            $table->double('max')->default(0);
            $table->double('min')->default(0);
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
        Schema::dropIfExists('parameters');
    }
};
