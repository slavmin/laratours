<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourObjectAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_object_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('objectable');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('qnt')->nullable();
            $table->unsignedDecimal('price')->nullable();
            $table->json('extra')->nullable();
            $table->unsignedBigInteger('customer_type_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->timestamps();

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
        Schema::dropIfExists('tour_object_attributes');
    }
}
