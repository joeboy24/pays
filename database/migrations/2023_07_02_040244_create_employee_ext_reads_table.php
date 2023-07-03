<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExtReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_ext_reads', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 12);

            $table->string('staff_id', 24)->nullable();
            $table->string('tin', 24)->nullable();
            $table->string('fname', 50)->nullable();
            $table->string('sname', 50)->nullable(); 
            $table->string('oname', 50)->nullable();
            $table->string('dob', 50)->nullable();
            $table->string('date_emp', 50)->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('prev_place', 50)->nullable();
            $table->string('cur_pos', 50)->nullable();
            $table->string('qual', 50)->nullable();
            $table->string('grade', 50)->nullable();
            $table->string('level', 50)->nullable();
            $table->string('step', 50)->nullable();
            $table->string('ssnit_no', 50)->nullable();
            $table->string('contact', 50)->nullable();
            $table->string('email', 50)->nullable();

            $table->string('photo', 50)->default('noimage.png', 50);
            $table->string('status', 50)->default('Active', 50); 
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
        Schema::dropIfExists('employee_ext_reads');
    }
}
