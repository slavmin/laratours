<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerTypeFieldToTourObjectAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_object_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_type_id')->nullable()->after('extra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_object_attributes', function (Blueprint $table) {
            $table->dropColumn('customer_type_id');
        });
    }
}
