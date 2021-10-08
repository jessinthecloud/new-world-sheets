<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceDataTable extends Migration
{
    public function up()
    {
        Schema::create( 'experience_data', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->integer('skill_level')->default(0);
            $table->integer('xp_to_next_level')->default(0);
            $table->integer('xp_at_current_level')->default(0);
            $table->integer('total_xp')->default(0);
            $table->integer('character_xp')->default(0);
            $table->float('efficiency')->default(0.00);
            $table->integer('bonus_roll')->default(0);
            $table->foreignId('tradeskill_id')->constrained();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'experience_data' );
    }
}