<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_pays', function (Blueprint $table) {
            $table->id();
            // 'employee_id','amt_paid','amt_rem','dur','del'
            $table->string('user_id');
            $table->string('employee_id');
            $table->string('amt_paid')->default(0);
            $table->string('amt_rem')->default(0);
            // $table->string('dur')->default(12);
            $table->string('desc')->default('direct pay');
            $table->string('monthly_dud')->default(0);
            $table->string('del')->default('no');
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
        Schema::dropIfExists('direct_pays');
    }
}
