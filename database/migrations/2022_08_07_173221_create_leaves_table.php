<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('with_pay')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('resume_date')->nullable();
            $table->string('days')->nullable();
            $table->string('hand_over')->nullable();
            $table->string('leave_notes')->nullable();
            $table->string('file_scan')->default('nofile.png');
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('leaves');
    }
}
