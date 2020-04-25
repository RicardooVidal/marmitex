<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_id')->references('id')->on('restaurants');
            $table->string('nome_conv');
            $table->string('prato')->nullable();
            $table->integer('quantidade')->nullable();
            $table->date('data')->nullable();
            $table->decimal('valor',5,2)->nullable();
            $table->decimal('valor_desconto',5,2)->nullable();
            $table->string('observacao')->nullable();
            $table->decimal('frete',5,2)->nullable();
            $table->boolean('situacao')->nullable();
            $table->decimal('adicional',5,2)->nullable();
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
        Schema::dropIfExists('guests');
    }
}
