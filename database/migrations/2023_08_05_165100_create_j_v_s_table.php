<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJVSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_v_s', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 12);
            $table->string('title', 50)->nullable();
            $table->string('debit', 24)->nullable();
            $table->string('credit', 24)->nullable();
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
        Schema::dropIfExists('j_v_s');
    }
}
