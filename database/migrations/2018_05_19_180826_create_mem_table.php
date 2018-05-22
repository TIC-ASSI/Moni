<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->integer('total')->nullable();
            $table->integer('available')->nullable();
            $table->integer('used')->nullable();
            $table->decimal('percent', 4, 1)->nullable();
            $table->integer('free')->nullable();
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
        Schema::dropIfExists('mem');
    }
}
