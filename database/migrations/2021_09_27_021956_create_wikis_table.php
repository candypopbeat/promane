<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWikisTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wikis', function (Blueprint $table) {
			$table->id();
			$table->string('title')->comment("タイトル");
			$table->foreignId("user_id")->comment("ユーザーIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->foreignId("team_id")->comment("チームIDとカスケードUPDEL")->constrained()->onUpdate('cascade')->onDelete('cascade');
			$table->longText('tags')->nullable()->comment("タグ、json型として配列扱いをする");
			$table->longText('contents')->nullable()->comment("内容、HTML記述もある");
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
		Schema::dropIfExists('wikis');
	}
}
