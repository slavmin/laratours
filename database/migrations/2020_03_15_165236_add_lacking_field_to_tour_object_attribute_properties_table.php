<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldToTourObjectAttributePropertiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_object_attribute_properties', function (Blueprint $table) {
      $table->unsignedInteger('margin')->nullable()->after('tour_price_type_id');
      $table->unsignedInteger('commission')->nullable()->after('margin');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tour_object_attribute_properties', function (Blueprint $table) {
      $table->dropColumn('margin', 'commission');
    });
  }
}
