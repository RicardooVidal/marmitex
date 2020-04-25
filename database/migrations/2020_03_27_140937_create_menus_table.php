<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_id')->references('id')->on('restaurants');
            $table->string('p1')->nullable();
            $table->string('p2')->nullable();
            $table->string('p3')->nullable();
            $table->string('p4')->nullable();
            $table->string('p5')->nullable();
            $table->string('p6')->nullable();
            $table->string('p7')->nullable();
            $table->string('p8')->nullable();
            $table->decimal('pr1',5,2)->nullable();
            $table->decimal('pr2',5,2)->nullable();
            $table->decimal('pr3',5,2)->nullable();
            $table->decimal('pr4',5,2)->nullable();
            $table->decimal('pr5',5,2)->nullable();
            $table->decimal('pr6',5,2)->nullable();
            $table->decimal('pr7',5,2)->nullable();
            $table->decimal('pr8',5,2)->nullable();
            $table->decimal('frete',5,2)->nullable();
            $table->decimal('adicional',5,2)->nullable();
            $table->date('data')->nullable();
            $table->boolean('fechado')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
