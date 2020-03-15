<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourExtrasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tour_extras', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->text('name');
      $table->text('description')->nullable();
      $table->unsignedInteger('value')->nullable();
      $table->unsignedInteger('price')->nullable();
      $table->unsignedInteger('margin')->nullable();
      $table->unsignedInteger('commission')->nullable();
      $table->unsignedBigInteger('tour_id')->nullable();
      $table->unsignedBigInteger('team_id')->nullable()->index();
      $table->timestamps();

      $table->foreign('team_id')
        ->references('id')
        ->on(\Config::get('teamwork.teams_table'))
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
    Schema::dropIfExists('tour_extras');
  }
}
