<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactFieldsToTourOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_orders', function (Blueprint $table) {
      $table->text('email')->after('invoice')->nullable();
      $table->text('phone')->after('email')->nullable();
      $table->text('contact_name')->after('phone')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_orders', function (Blueprint $table) {
      $table->dropColumn('email', 'phone', 'contact_name');
    });
  }
}
