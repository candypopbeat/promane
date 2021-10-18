<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options', function (Blueprint $table) {
			$table->id();
			$table->foreignId("team_id")->comment("チームIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->string('project_title')->nullable()->comment("プロジェクトのタイトル");
			$table->boolean("view_contributor")->default(false)->comment("タスク投稿者を表示するかどうか");
			$table->longText('theme_colors')->nullable()->comment("テーマカラー、json型として配列扱いをする");
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
		Schema::dropIfExists('options');
	}
}
