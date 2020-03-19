<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('endereco');
            $table->string('bairro');
            $table->string('numero');
            $table->integer('cep');
            $table->bigInteger('telefone');
            $table->biginteger('celular');
            $table->double('vlr_m');
            $table->double('frete');
            $table->string('responsavel');
            $table->boolean('cobfr'); // Cobra Frete ?
            $table->boolean('cobad'); // Cobra Adicional ?
            $table->boolean('padrao'); // É padrão ?
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
        Schema::dropIfExists('restaurants');
    }
}
