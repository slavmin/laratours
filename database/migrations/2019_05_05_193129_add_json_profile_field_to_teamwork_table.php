<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJsonProfileFieldToTeamworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\Config::get( 'teamwork.teams_table' ), function (Blueprint $table) {
            $table->json('meta')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\Config::get( 'teamwork.teams_table' ), function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
}
