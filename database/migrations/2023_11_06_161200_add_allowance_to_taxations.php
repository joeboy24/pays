<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowanceToTaxations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taxations', function (Blueprint $table) {
            $table->string('resp', 50)->default(0);
            $table->string('risk', 50)->default(0);
            $table->string('vma', 50)->default(0);
            $table->string('ent', 50)->default(0);
            $table->string('dom', 50)->default(0);
            $table->string('intr', 50)->default(0);
            $table->string('tnt', 50)->default(0);
            $table->string('cola', 50)->default(0);
            $table->string('new1', 50)->default(0);
            $table->string('new2', 50)->default(0);
            $table->string('new3', 50)->default(0);
            $table->string('new4', 50)->default(0);
            $table->string('new5', 50)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxations', function (Blueprint $table) {
            //
        });
    }
}
