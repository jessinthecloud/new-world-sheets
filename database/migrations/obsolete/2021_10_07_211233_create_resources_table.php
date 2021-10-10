<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    public function up()
    {
        Schema::create( 'resources', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name')->unique();
            $table->string('tier');
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'resources' );
    }
}