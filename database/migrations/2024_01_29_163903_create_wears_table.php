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
        Schema::create('wears', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("image");
            $table->unsignedBigInteger("seasone_id");
            $table->unsignedBigInteger("sport_id");
            $table->foreign("seasone_id")->references("id")->on("seasones")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("sport_id")->references("id")->on("sports")->onUpdate("cascade")->onDelete("cascade");
            $table->unique(["seasone_id","sport_id"]);
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
        Schema::dropIfExists('wears');
    }
};
