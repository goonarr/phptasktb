<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnjigeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knjige', function (Blueprint $table) {
            $table->id();
            $table->string('naziv', 250);
            $table->string('autor', 250);
            $table->string('izdavac', 250);
            $table->bigInteger('godina_izdanja');
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
        Schema::dropIfExists('knjige');
    }
}
