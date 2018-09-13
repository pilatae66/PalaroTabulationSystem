<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')
            ->references('id')->on('events')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedInteger('judge_id');
            $table->foreign('judge_id')
            ->references('id')->on('judges')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedInteger('criteria_id');
            $table->foreign('criteria_id')
            ->references('id')->on('criterias')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedInteger('contestant_id');
            $table->foreign('contestant_id')
            ->references('id')->on('contestants')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->integer('score');
            $table->string('category')->nullable();
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
        Schema::dropIfExists('scores');
    }
}
