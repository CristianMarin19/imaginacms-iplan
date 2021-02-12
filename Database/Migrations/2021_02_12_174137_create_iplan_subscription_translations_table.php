<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanSubscriptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__subscription_translations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description');
            $table->string('category_name');

            $table->bigInteger('subscription_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['subscription_id', 'locale']);
            $table->foreign('subscription_id')->references('id')->on('iplan__subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iplan__subscription_translations');
    }
}
