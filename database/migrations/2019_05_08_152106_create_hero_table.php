<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->enum('type', \App\Models\Hero::TYPES);
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('max_heatpoint');
            $table->bigInteger('current_heatpoint');
            $table->bigInteger('experience')->default(0);
            $table->smallInteger('lvl')->default(1);
            $table->integer('attack')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('enemies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->enum('type', \App\Models\Enemy::ENEMY_TYPES)->default('wolf');
            $table->smallInteger('lvl');
            $table->integer('attack');
            $table->integer('heatpoint');
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
        Schema::dropIfExists('enemies');
        Schema::dropIfExists('heroes');
    }
}
