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
        Schema::create('replacments', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->unsignedBigInteger("inplayer_id");
            $table->unsignedBigInteger("outplayer_id");
            $table->unsignedBigInteger("matche_id");
            $table->foreign("inplayer_id")->references("id")->on("players")->onUpdate("cascade");
            $table->foreign("outplayer_id")->references("id")->on("players")->onUpdate("cascade");
            $table->foreign("matche_id")->references("id")->on("matches")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["inplayer_id","outplayer_id","matche_id"]);
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
        Schema::dropIfExists('replacments');
    }
};
