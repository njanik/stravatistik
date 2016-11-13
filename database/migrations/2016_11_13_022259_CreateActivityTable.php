<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('strava_id')->index();
            $table->integer('athlete_id');
            $table->string('name');
            $table->unsignedInteger('distance');
            $table->unsignedInteger('moving_time');
            $table->unsignedInteger('elapsed_time');
            $table->integer('elevation');
            $table->json('strava_activity');
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
        Schema::table('activity', function (Blueprint $table) {
            //
        });
    }
}
