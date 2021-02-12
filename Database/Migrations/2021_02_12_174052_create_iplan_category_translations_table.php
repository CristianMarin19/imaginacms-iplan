<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__category_translations', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('description');
            $table->string('slug')->unique();

            $table->bigInteger('category_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('iplan__categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iplan__category_translations');
    }
}
