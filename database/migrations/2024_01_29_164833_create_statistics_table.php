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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("name");
            $table->json("value");
            $table->unsignedBigInteger("matche_id");
            $table->foreign("matche_id")->references("id")->on("matches")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["name","matche_id"]);
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
        Schema::dropIfExists('statistics');
    }
};
