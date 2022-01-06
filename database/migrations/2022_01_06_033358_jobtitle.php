<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jobtitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('jobtitle')) {
			Schema::create('jobtitle', function (Blueprint $table) {
				$table->id();
				$table->string('name');
				$table->string('code')->unique();
				$table->string('importance')->nullable();
				$table->string('is_boss')->default('not');
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
        Schema::dropIfExists('jobtitle');
    }
}
