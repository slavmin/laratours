<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->index();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get( 'teamwork.teams_table' ))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_cities');
    }
}
