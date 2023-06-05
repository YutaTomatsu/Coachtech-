<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsConditionsTable extends Migration
{
    public function up()
    {
        Schema::create('items_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('condition_id');
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items_conditions');
    }
}
