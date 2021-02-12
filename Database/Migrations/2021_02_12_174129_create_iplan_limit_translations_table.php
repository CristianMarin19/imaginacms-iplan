<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanLimitTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__limit_translations', function (Blueprint $table) {
            $table->id();

            $table->text('name');

            $table->bigInteger('limit_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['limit_id', 'locale']);
            $table->foreign('limit_id')->references('id')->on('iplan__limits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iplan__limit_translations');
    }
}
