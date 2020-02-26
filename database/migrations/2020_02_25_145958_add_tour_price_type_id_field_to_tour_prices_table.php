<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTourPriceTypeIdFieldToTourPricesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_prices', function (Blueprint $table) {
      $table->unsignedBigInteger('tour_price_type_id')->nullable()->after('price')->index();
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
      $table->dropColumn('tour_price_type_id');
    });
  }
}
