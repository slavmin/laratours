<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourables', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->morphs('tourable');
            $table->unsignedBigInteger('tour_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get( 'teamwork.teams_table' ))
                ->onDelete('cascade');

            $table->primary(['tour_id', 'tourable_id', 'tourable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourables');
    }
}
