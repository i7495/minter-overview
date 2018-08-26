<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address')->required();
            $table->string('public_key')->required();
            $table->string('name')->nullable();
            $table->string('site')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->nullable();
            $table->string('stake_total')->nullable();
            $table->string('stake_self')->nullable();
            $table->integer('commission')->nullable();
            $table->string('reward_accumulated')->nullable();
            $table->string('reward_total')->nullable();
            $table->integer('blocks_missed')->nullable();
            $table->integer('blocks_missed_total')->nullable();
            $table->integer('delegates')->nullable();
            $table->integer('declared_at_block')->required();
            $table->integer('declared_at_time')->required();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
