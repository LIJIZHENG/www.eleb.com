<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddoredersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addoreders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('order_code');
            $table->integer('order_birth_time');
            $table->smallInteger('order_status');
            $table->integer('shop_id');
            $table->string('shop_name');
            $table->string('shop_img');
            $table->string('provence');
            $table->string('city');
            $table->string('area');
            $table->string('detail_address');
            $table->string('tel');
            $table->string('name');
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
        Schema::dropIfExists('addoreders');
    }
}
