<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('template')->nullable();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->boolean('published')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('team_id')
            //     ->references('id')
            //     ->on(\Config::get( 'teamwork.teams_table' ));
            //     // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
