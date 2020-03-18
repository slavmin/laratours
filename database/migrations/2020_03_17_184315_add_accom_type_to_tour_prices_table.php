<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccomTypeToTourPricesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_prices', function (Blueprint $table) {
      $table->text('accom_type')->after('tour_customer_type_id')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_prices', function (Blueprint $table) {
      $table->dropColumn('accom_type');
    });
  }
}
