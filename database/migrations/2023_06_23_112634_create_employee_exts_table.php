<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_exts', function (Blueprint $table) {
            // 'user_id','employee_id','maiden_fname','maiden_sname','maiden_oname','address','ssnit_no',
            // 'last_emp_place','lep_add','lep_phone','lep_pos','father','father_status','mother_status',
            // 'spouse','spouse_status','nok','nok_contact','del'
            $table->id();
            $table->string('user_id', 50);
            $table->string('employee_id', 50);
            $table->string('address', 50)->nullable();
            $table->string('maiden_fname', 50)->nullable();
            $table->string('maiden_sname', 50)->nullable();
            $table->string('maiden_oname', 50)->nullable();
            $table->string('ssnit_no', 50)->nullable();
            $table->string('last_emp_place', 50)->nullable();
            $table->string('lep_add', 50)->nullable();
            $table->string('lep_phone', 50)->nullable();
            $table->string('lep_pos', 50)->nullable();
            $table->string('father', 50)->nullable();
            $table->string('father_status', 50)->nullable();
            $table->string('mother_status', 50)->nullable();
            $table->string('spouse', 50)->nullable();
            $table->string('spouse_status', 50)->nullable();
            $table->string('nok', 50)->nullable();
            $table->string('nok_contact', 50)->nullable();
            $table->string('mother_status', 50)->nullable();
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
        Schema::dropIfExists('employee_exts');
    }
}
