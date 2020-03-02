<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLackingFieldsToTourObjectAttributesPropertiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_object_attribute_properties', function (Blueprint $table) {
      $table->text('name')->nullable()->change();
      $table->text('value')->nullable()->change();
      $table->unsignedInteger('duration')->nullable()->change();
      $table->unsignedBigInteger('object_attribute_id')->after('tour_price_type_id');
      $table->json('days_array')->nullable()->after('object_attribute_id');
      $table->unsignedInteger('days')->nullable()->after('days_array');
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
      $table->dropColumn('object_attribute_id', 'days_array', 'days');
    });
  }
}
