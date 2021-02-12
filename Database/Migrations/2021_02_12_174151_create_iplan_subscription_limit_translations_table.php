<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanSubscriptionLimitTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__subscription_limit_translations', function (Blueprint $table) {
            $table->id();

            $table->text('name');

            $table->bigInteger('subscription_limit_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['subscription_limit_id', 'locale'],'subscription_locale');
            $table->foreign('subscription_limit_id','subs_limit_tr_fk')->references('id')->on('iplan__subscription_limits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iplan__subscription_limit_translations');
    }
}
