<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldsToToursTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tours', function (Blueprint $table) {
      $table->json('countries_list')->nullable()->after('description');
      $table->unsignedBigInteger('country_id')->after('countries_list');
      $table->unsignedBigInteger('tour_constructor_type_id')->after('city_id');
      $table->unsignedInteger('nights')->nullable()->after('duration');
      $table->unsignedInteger('qnt')->nullable()->after('nights');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tours', function (Blueprint $table) {
      $table->dropColumn(
        'tour_constructor_type_id',
        'country_id',
        'countries_list',
        'nights',
        'qnt'
      );
    });
  }
}
