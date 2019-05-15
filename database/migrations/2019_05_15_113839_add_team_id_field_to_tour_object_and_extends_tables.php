<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamIdFieldToTourObjectAndExtendsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_object_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->index()->after('extra');

            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get( 'teamwork.teams_table' ))
                ->onDelete('cascade');
        });

        Schema::table('extends', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->index()->after('content');

            $table->foreign('team_id')
                ->references('id')
                ->on(\Config::get( 'teamwork.teams_table' ))
                ->onDelete('cascade');
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
            $table->dropForeign('tour_object_attributes_team_id_foreign');
            $table->dropColumn('team_id');
        });

        Schema::table('extends', function (Blueprint $table) {
            $table->dropForeign('extends_team_id_foreign');
            $table->dropColumn('team_id');
        });
    }

}
