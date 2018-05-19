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
            $table->integer('total');
            $table->integer('available');
            $table->integer('used');
            $table->decimal('percent',4,1);
            $table->integer('free');
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
