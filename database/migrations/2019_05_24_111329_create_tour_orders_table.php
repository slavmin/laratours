<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tour_id')->nullable()->index();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0)->index();
            $table->decimal('total_price')->nullable();
            $table->decimal('commission')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('total_paid')->nullable();
            $table->string('invoice')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('set null');
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
        Schema::dropIfExists('tour_orders');
    }
}
