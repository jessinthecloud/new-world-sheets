<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmorTable extends Migration
{
    public function up()
    {
        Schema::create( 'armor', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string("name")->nullable();
            $table->string("name_with_affixes")->nullable();
            $table->string("description")->nullable();
            $table->string("parsed_description")->nullable();
            $table->string("item_type")->nullable();
            $table->string("item_class")->nullable();
            $table->string("slug")->nullable();
            $table->string("tier")->nullable();
            $table->string("rarity")->nullable();
            $table->string("gear_score_override")->nullable();
            $table->integer("min_gear_score")->nullable();
            $table->integer("max_gear_score")->nullable();
            $table->integer("required_level")->nullable();
            $table->string("icon_path")->nullable();
            $table->string("cdn_asset_path")->nullable();
            $table->string("item_class_en")->nullable();
            $table->string("source")->nullable();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'armor' );
    }
}