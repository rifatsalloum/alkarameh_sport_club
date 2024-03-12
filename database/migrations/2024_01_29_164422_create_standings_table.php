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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->integer("win")->default(0);
            $table->integer("lose")->default(0);
            $table->integer("draw")->default(0);
            $table->integer("diff")->default(0);
            $table->integer("points")->default(0);
            $table->integer("play")->default(0);
            $table->unsignedBigInteger("seasone_id");
            $table->unsignedBigInteger("club_id");
            $table->foreign("seasone_id")->references("id")->on("seasones")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("club_id")->references("id")->on("clubs")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["seasone_id","club_id"]);
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
        Schema::dropIfExists('standings');
    }
};
