<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourObjectAttributeProperties extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tour_object_attribute_properties', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->text('name');
      $table->text('description')->nullable();
      $table->text('value');
      $table->unsignedInteger('duration');
      $table->unsignedBigInteger('tour_id')->nullable();
      $table->unsignedBigInteger('tour_price_type_id')->nullable();
      $table->unsignedBigInteger('team_id')->nullable()->index();
      $table->timestamps();
      $table->softDeletes();

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
    Schema::dropIfExists('tour_object_attribute_properties');
  }
}
