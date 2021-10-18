<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->string('title')->comment("タイトル");
			$table->foreignId("user_id")->comment("ユーザーIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId("team_id")->comment("チームIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->boolean("follow")->default(false)->comment("フォロー");
			$table->unsignedInteger('status')->comment("状態");
			$table->longText('tags')->nullable()->comment("タグ、json型として配列扱いをする");
			$table->longText('contents')->nullable()->comment("内容、HTML記述もある");
			$table->unsignedInteger('progress')->default(0)->comment("進捗、％");
			$table->unsignedInteger('sort')->default(0)->comment("順番");
			$table->timestamp('start_time', $precision = 0)->useCurrent()->comment("開始日時");
			$table->timestamp('end_time', $precision = 0)->useCurrent()->comment("終了日時");
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
		Schema::dropIfExists('tasks');
	}
}
