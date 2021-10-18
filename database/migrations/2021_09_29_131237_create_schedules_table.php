<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function (Blueprint $table) {
			$table->id();
			$table->string('title')->comment("スケジュール名であり、タスクのタグと連動する");
			$table->foreignId("user_id")->comment("ユーザーIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId("team_id")->comment("チームIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->unsignedInteger('sort')->default(0)->comment("順番");
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
		Schema::dropIfExists('schedules');
	}
}
