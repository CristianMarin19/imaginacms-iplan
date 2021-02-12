<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__subscriptions', function (Blueprint $table) {
            $table->id();

            $table->string('entity');
            $table->string('entity_id');
            $table->integer('frequency');
            $table->dateTime('date_start');
            $table->dateTime('date_end');

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
        Schema::dropIfExists('iplan__subscriptions');
    }
}
