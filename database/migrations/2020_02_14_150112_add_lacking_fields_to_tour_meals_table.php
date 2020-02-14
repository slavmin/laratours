<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldsToTourMealsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_meals', function (Blueprint $table) {
      $table->text('address')->nullable();
      $table->text('site')->nullable();
      $table->text('email')->nullable();
      $table->text('phone')->nullable();
      $table->text('staff_name')->nullable();
      $table->text('staff_phone')->nullable();
      $table->string('photo_location')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_meals', function (Blueprint $table) {
      $table
        ->dropColumn(
          'address',
          'site',
          'email',
          'phone',
          'staff_name',
          'staff_phone',
          'photo_location'
        );
    });
  }
}
