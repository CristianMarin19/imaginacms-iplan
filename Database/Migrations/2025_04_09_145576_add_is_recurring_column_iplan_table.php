<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->integer('is_recurring')->unsigned()->default(0)->after('trial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->dropColumn('is_recurring');
        });
    }
};
