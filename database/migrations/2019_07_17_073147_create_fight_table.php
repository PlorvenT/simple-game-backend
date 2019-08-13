<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hero_id');
            $table->unsignedBigInteger('enemy_id');
            $table->timestamp('date_start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_end')->nullable();
            $table->integer('gold_award')->nullable();
            $table->integer('experience_award')->nullable();
            $table->enum('status', ['win', 'lose', 'in_progress'])->default('in_progress');

            $table->foreign('hero_id')
                ->references('id')->on('heroes')
                ->onDelete('cascade');
            $table->foreign('enemy_id')
                ->references('id')->on('enemies')
                ->onDelete('cascade');
        });

        Schema::create('fight_logs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('fight_id');
            $table->string('type', 50);
            $table->string('description', 255);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('fight_id')
                ->references('id')->on('fights')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fight_logs');
        Schema::dropIfExists('fights');
    }
}
