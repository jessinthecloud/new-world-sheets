<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRecipeTable extends Migration
{
    public function up()
    {
        // items used as ingredients
        Schema::create( 'item_recipe', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->integer('amount');
            // get recipe type via items.item_state info
            $table->foreignId("item_id")->constrained();
            $table->foreignId("recipe_id")->constrained();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'item_recipe' );
    }
}