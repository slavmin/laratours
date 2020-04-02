<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSingleFieldToTourObjectAttributePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_object_attribute_properties', function (Blueprint $table) {
            $table->boolean('is_single')->after('hotel')->default(0);
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
            $table->dropColumn('is_single');
        });
    }
}
