<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjectTypeHotelMealEventsFieldsToTourObjectAttributePropertiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tour_object_attribute_properties', function (Blueprint $table) {
      $table->text('object_type')->after('object_attribute_id');
      $table->unsignedBigInteger('hotel')->nullable()->after('object_type');
      $table->unsignedBigInteger('meal')->nullable()->after('hotel');
      $table->json('events')->nullable()->after('meal');
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
      $table->dropColumn('object_type', 'hotel', 'meal', 'events');
    });
  }
}
