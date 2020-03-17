<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldsToTourGuidesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_guides', function (Blueprint $table) {
      $table->unsignedBigInteger('city_id')->after('extra');
      $table->unsignedBigInteger('country_id')->after('city_id');
      $table->text('address')->after('country_id')->nullable();
      $table->json('grade_list')->after('address')->nullable();
      $table->json('lang_list')->after('grade_list')->nullable();
      $table->text('email')->after('lang_list')->nullable();
      $table->text('phone')->after('email')->nullable();
      $table->text('secret_phone')->after('phone')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_guides', function (Blueprint $table) {
      $table->dropColumn(
        'city_id',
        'country_id',
        'grade_list',
        'lang_list',
        'address',
        'email',
        'phone',
        'secret_phone'
      );
    });
  }
}
