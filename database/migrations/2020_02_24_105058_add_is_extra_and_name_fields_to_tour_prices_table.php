<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsExtraAndNameFieldsToTourPricesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_prices', function (Blueprint $table) {
      $table->text('name')->nullable()->after('period_end');
      $table->boolean('is_extra')->nullable()->default(0)->index()->after('price');
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
      $table
        ->dropColumn(
          'name',
          'is_extra',
        );
    });
  }
}
