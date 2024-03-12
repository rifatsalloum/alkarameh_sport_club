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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->dateTime("when");
            $table->enum("status",["not_started","finished"]);
            $table->string("plan");
            $table->string("channel");
            $table->integer("round");
            $table->string("play_ground");
            $table->unsignedBigInteger("seasone_id");
            $table->unsignedBigInteger("club1_id");
            $table->unsignedBigInteger("club2_id");
            $table->foreign("seasone_id")->references("id")->on("seasones");
            $table->foreign("club1_id")->references("id")->on("clubs")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("club2_id")->references("id")->on("clubs")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["round","club1_id","club2_id","seasone_id"]);
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
        Schema::dropIfExists('matches');
    }
};
