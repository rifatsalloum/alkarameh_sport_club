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
        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("name");
            $table->string("description");
            $table->string("image");
            $table->enum("type",["personal","club"]);
            $table->unsignedBigInteger("seasone_id");
            $table->unsignedBigInteger("sport_id");
            $table->foreign("seasone_id")->references("id")->on("seasones")->onUpdate("cascade");
            $table->foreign("sport_id")->references("id")->on("sports")->onUpdate("cascade");
            $table->unique(["name","seasone_id","sport_id"]);
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
        Schema::dropIfExists('primes');
    }
};
