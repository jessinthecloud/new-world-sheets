<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create( 'items', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("full_name")->nullable();
            $table->text("description")->nullable();
            $table->string("tier")->nullable();
            $table->string("rarity")->nullable();
            $table->string("item_type")->nullable();
            // raw or refined or null
            $table->string("item_state")->nullable();
            // player level, not tradeskill
            $table->integer("required_skill_level")->nullable();
            $table->string("image")->nullable();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'items' );
    }
}