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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('connection_id')
                ->constrained('connections', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('topic');
            // $table->longText('raw');
            $table->timestamp('last_received')->nullable();
            $table->integer('conn_flag')->default(0);
            $table->integer('soft_delete')->default(0);
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
        Schema::dropIfExists('topics');
    }
};
