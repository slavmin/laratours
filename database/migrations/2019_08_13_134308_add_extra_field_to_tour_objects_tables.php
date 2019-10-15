<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldToTourObjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_attendants', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });

        Schema::table('tour_guides', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });

        Schema::table('tour_hotels', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });

        Schema::table('tour_meals', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });

        Schema::table('tour_museums', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });

        Schema::table('tour_transports', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_attendants', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('tour_guides', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('tour_hotels', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('tour_meals', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('tour_museums', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('tour_transports', function (Blueprint $table) {
            $table->dropColumn('extra');
        });
    }
}
