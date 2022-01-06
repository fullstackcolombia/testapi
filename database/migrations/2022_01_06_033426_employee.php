<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee')) {
			Schema::create('employee', function (Blueprint $table) {
				$table->id();
				$table->string('name');
				$table->string('lastname');
				$table->string('dni');
				$table->timestamp('date_of_birth')->nullable();
				$table->string('photo')->nullable();
				$table->unsignedBigInteger('user_id');
				$table->foreign('user_id')->references('id')->on('users');
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
        if (Schema::hasTable('employee')) {
			Schema::table('employee', function (Blueprint $table) {
				$table->dropForeign(['user_id']);
			});
		}
		Schema::dropIfExists('employee');
		
    }
}
