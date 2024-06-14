<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->string('title');
            $table->date('release');
            $table->string('length');
            $table->string('description');
            $table->string('mpaa_rating');
            $table->string('genre_1');
            $table->string('genre_2');
            $table->string('genre_3');
            $table->string('director');
            $table->string('actor_1');
            $table->string('actor_2');
            $table->string('actor_3');
            $table->string('language');
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
        Schema::dropIfExists('movies');
    }
};
