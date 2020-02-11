<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldsToTourMuseumsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_museums', function (Blueprint $table) {
      $table->json('types_list')->nullable();
      $table->text('address')->nullable();
      $table->text('museum_site')->nullable();
      $table->text('museum_email')->nullable();
      $table->text('museum_phone')->nullable();
      $table->text('staff_name')->nullable();
      $table->text('staff_phone')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_museums', function (Blueprint $table) {
      $table
        ->dropColumn(
          'types_list',
          'address',
          'museum_site',
          'museum_email',
          'museum_phone',
          'staff_name',
          'staff_phone'
        );
    });
  }
}
