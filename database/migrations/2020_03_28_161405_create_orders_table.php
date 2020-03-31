<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_id')->references('id')->on('restaurants');
            $table->string('func_id')->references('id')->on('employees');;
            $table->string('prato')->nullable();
            $table->integer('quantidade')->nullable();
            $table->date('data')->nullable();
            $table->double('valor')->nullable();
            $table->double('valor_desconto')->nullable();
            $table->string('observacao');
            $table->double('frete');
            $table->boolean('situacao')->nullable();
            $table->double('adicional');
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
        Schema::dropIfExists('orders');
    }
}
