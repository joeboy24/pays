<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_grants', function (Blueprint $table) {
            $table->id();
            // 'user_id','employee_id','loan_amt','monthly_dud','dur','loan_type','status','del'
            $table->string('user_id');
            $table->string('employee_id');
            $table->string('loan_amt')->default(0);
            $table->string('monthly_dud')->default(0);
            $table->string('dur')->default(0);
            $table->string('loan_type')->default(0);
            $table->string('status')->default('unpaid');
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
        Schema::dropIfExists('loan_grants');
    }
}
