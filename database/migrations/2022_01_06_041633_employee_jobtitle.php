<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeJobtitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee_jobtitle')) {
			Schema::create('employee_jobtitle', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('employee_id');
				$table->foreign('employee_id')->references('id')->on('employee');
				$table->unsignedBigInteger('jobtitle_id');
				$table->foreign('jobtitle_id')->references('id')->on('jobtitle');
				$table->timestamps();
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
