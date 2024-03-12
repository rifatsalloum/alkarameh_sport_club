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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("name")->unique();
            $table->integer("high");
            $table->enum("play",["GK","LB","CB","RB","LM","CM","AM","DM","RM","LW","CF","RW"]);
            $table->integer("number")->unique();
            $table->date("born");
            $table->string("from");
            $table->string("first_club");
            $table->string("career");
            $table->string("image");
            $table->unsignedBigInteger("sport_id");
            $table->foreign("sport_id")->references("id")->on("sports")->onUpdate("cascade");
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
        Schema::dropIfExists('players');
    }
};
