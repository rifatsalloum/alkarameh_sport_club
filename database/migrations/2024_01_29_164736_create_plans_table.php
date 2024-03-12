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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->unsignedBigInteger("player_id");
            $table->unsignedBigInteger("matche_id");
            $table->enum("status",["main","beanch"]);
            $table->foreign("player_id")->references("id")->on("players")->onUpdate("cascade");
            $table->foreign("matche_id")->references("id")->on("matches")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(["player_id","matche_id"]);
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
        Schema::dropIfExists('plans');
    }
};
