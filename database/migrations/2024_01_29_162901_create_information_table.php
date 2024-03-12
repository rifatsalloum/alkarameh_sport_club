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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("title")->nullable();
            $table->string("content")->nullable();
            $table->string("image");
            $table->integer("reads")->default(0);
            $table->enum("type",["strategy","news","regular","slider"]);
            $table->morphs("information_able");
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
        Schema::dropIfExists('information');
    }
};
