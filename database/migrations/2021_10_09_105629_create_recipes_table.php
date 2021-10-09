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
            $table->string("slug")->unique();
            $table->string("achievement_id")->nullable();
            $table->integer("base_gear_score")->nullable();
            $table->string("base_tier")->nullable();
            $table->float("bonus_item_chance")->nullable();
            $table->string("bonus_item_chance_decrease")->nullable();
            $table->string("bonus_item_chance_increase")->nullable();
            $table->string("category")->nullable();
            $table->string("cooldown_quantity")->nullable();
            $table->string("cooldown_seconds")->nullable();
            $table->integer("crafting_fee")->nullable();
            $table->float("crafting_time")->nullable();
            $table->string("display_ingredients")->nullable();
            $table->string("game_event_id")->nullable();
            $table->string("gear_score_bonus")->nullable();
            $table->string("gear_score_range")->nullable();
            $table->string("gear_score_reduction")->nullable();
            $table->string("group")->nullable();
            $table->bigInteger("housing_item_id")->nullable();
            $table->boolean("is_procedural")->nullable();
            $table->boolean("is_temporary")->nullable();
            $table->bigInteger("item_id")->nullable();
            $table->text("recipe_id")->nullable();
            $table->integer("recipe_level")->nullable();
            $table->string("recipe_name")->nullable();
            $table->string("recipe_name_override")->nullable();
            $table->string("recipe_tags")->nullable();
            $table->string("required_achievement_id")->nullable();
            $table->string("station_type_1")->nullable();
            $table->string("station_type_2")->nullable();
            $table->string("station_type_3")->nullable();
            $table->string("station_type_4")->nullable();
            $table->string("station_type2")->nullable();
            $table->string("station_type3")->nullable();
            $table->string("station_type4")->nullable();
            $table->string("tradeskill")->nullable();
            $table->string("cdn_asset_path")->nullable();
            $table->string("item_class")->nullable();
            $table->string("rarity")->nullable();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'recipes' );
    }
}