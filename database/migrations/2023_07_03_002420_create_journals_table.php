<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'user_id','month','gross','ssf_emp','fuel_alw','back_pay','total_ssf','total_paye','advances','veh_loan','staff_loan','net_pay','debit','credit','status','del'
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 12);
            $table->string('month', 24)->nullable();
            $table->string('gross', 24)->nullable();
            $table->string('ssf_emp', 24)->nullable();
            $table->string('fuel_alw', 24)->nullable();
            $table->string('back_pay', 24)->nullable();
            $table->string('total_ssf', 24)->nullable();
            $table->string('total_paye', 24)->nullable();
            $table->string('advances', 24)->nullable();
            $table->string('veh_loan', 24)->nullable();
            $table->string('staff_loan', 24)->nullable();
            $table->string('net_pay', 24)->nullable();
            $table->string('debit', 24)->nullable();
            $table->string('credit', 24)->nullable();
            $table->string('status', 24)->nullable();
            $table->string('del', 5)->default('no');
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
        Schema::dropIfExists('journals');
    }
}
