<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanSubscriptionLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__subscription_limits', function (Blueprint $table) {
            $table->id();

            $table->string('entity');
            $table->string('attribute')->nullable();
            $table->string('attribute_value')->nullable();
            $table->integer('quantity')->unsigned();
            $table->integer('quantity_used')->unsigned();

            $table->bigInteger('subscription_id')->unsigned();
            $table->foreign('subscription_id','subs_limit_subscript')->references('id')->on('iplan__subscriptions')->onDelete('cascade');

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
        Schema::dropIfExists('iplan_subscription_limits');
    }
}
