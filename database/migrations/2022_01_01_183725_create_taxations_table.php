<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 50);
            $table->string('month', 50);
            $table->string('employee_id', 50);
            $table->string('position', 50);
            $table->string('salary', 50);
            $table->string('rent', 50);
            $table->string('prof', 50);

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
            
            $table->string('tot_income', 50);
            $table->string('ssf', 50);
            $table->string('taxable_inc', 50);
            $table->string('tax_pay', 50);
            $table->string('first1', 50);
            $table->string('next1', 50);
            $table->string('next2', 50);
            $table->string('next3', 50);
            $table->string('next4', 50);
            $table->string('next5', 50);
            $table->string('net_amount', 50);
            $table->string('del', 50)->default('no', 50);
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
        Schema::dropIfExists('taxations', 50);
    }
}
