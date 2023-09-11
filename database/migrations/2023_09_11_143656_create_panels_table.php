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
        Schema::create('panels', function (Blueprint $table) {
            $table->id();
            $table->string('panel_name');
            $table->foreignId('dashboard_id')
                ->constrained('dashboards', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('parameter_id');
            // $table->string('type');
            $table->integer('size');
            $table->integer('order');
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
        Schema::dropIfExists('panels');
    }
};
