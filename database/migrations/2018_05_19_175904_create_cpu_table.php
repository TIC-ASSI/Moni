<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->integer('cores')->nullable();
            $table->decimal('percent', 4, 1)->nullable();
            $table->decimal('frequency', 6, 2)->nullable();
            $table->decimal('min_frequency', 6, 2)->nullable();
            $table->decimal('max_frequency', 6, 2)->nullable();
            $table->integer('time_id')->nullable();
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
        Schema::dropIfExists('cpu');
    }
}
