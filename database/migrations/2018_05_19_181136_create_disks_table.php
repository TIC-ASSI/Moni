<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->string('device')->nullable();
            $table->string('mount_point')->nullable();
            $table->string('file_system')->nullable();
            $table->decimal('total', 7, 2)->nullable();
            $table->decimal('used', 7, 2)->nullable();
            $table->decimal('free', 7, 2)->nullable();
            $table->decimal('percent', 4, 1)->nullable();
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
        Schema::dropIfExists('disks');
    }
}
