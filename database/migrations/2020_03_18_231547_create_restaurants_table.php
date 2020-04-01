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
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero')->nullable();
            $table->integer('cep')->nullable();
            $table->bigInteger('telefone')->nullable();
            $table->biginteger('celular');
            $table->double('vlr_m')->nullable();
            $table->double('frete')->nullable();
            $table->double('adicional')->nullable();
            $table->string('responsavel');
            $table->boolean('cobfr')->nullable(); // Cobra Frete ?
            $table->boolean('cobad')->nullable(); // Cobra Adicional ?
            $table->boolean('padrao')->nullable(); // Ã‰ padrÃ£o ?
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
