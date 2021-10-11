<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    public function up()
    {
        Schema::create( 'recipes', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string("name")->unique();
            $table->string("slug")->unique();
            $table->string("category")->nullable();
            $table->foreignId("tradeskill_id")->constrained();
            // crafted item
            $table->foreignId("item_id")->constrained();
            
//            $table->string("required_station_id")->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'recipes' );
    }
}