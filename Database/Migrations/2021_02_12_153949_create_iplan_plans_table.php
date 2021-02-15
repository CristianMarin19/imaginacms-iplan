<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description');
            $table->integer('frequency_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('iplan__categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('iplan__plans');
    }
}
