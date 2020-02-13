<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('priceable');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('price');
            $table->unsignedBigInteger('tour_customer_type_id')->nullable()->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->timestamps();

            $table
                ->foreign('tour_customer_type_id')
                ->references('id')
                ->on('tour_customer_types');

            $table
                ->foreign('team_id')
                ->references('id')
                ->on(\Config::get('teamwork.teams_table'))
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
        Schema::dropIfExists('tour_prices');
    }
}
