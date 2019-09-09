<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->json('cities_list')->nullable();
            $table->unsignedBigInteger('tour_type_id')->nullable()->index();
            $table->unsignedInteger('duration')->nullable()->index();
            $table->unsignedInteger('commission')->nullable();
            $table->json('extra')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->dateTime('expire_at')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('tours');
    }
}
