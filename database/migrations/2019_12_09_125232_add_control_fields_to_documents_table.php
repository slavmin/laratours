<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddControlFieldsToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->boolean('pdf_for_agent')->default(0);
            $table->boolean('word_for_agent')->default(0);
            $table->boolean('pdf_for_tourist')->default(0);
            $table->boolean('word_for_tourist')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table
                ->dropColumn(
                    'pdf_for_agent', 'word_for_agent', 'pdf_for_tourist', 'word_for_tourist'
                );
        });
    }
}
