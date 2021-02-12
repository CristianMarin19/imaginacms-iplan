<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__limits', function (Blueprint $table) {
            $table->id();

            $table->string('entity');
            $table->string('attribute')->nullable();
            $table->string('attribute_value')->nullable();
            $table->integer('quantity')->unsigned();

            $table->bigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('iplan__plans')->onDelete('cascade');

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
        Schema::dropIfExists('iplan__limits');
    }
}
