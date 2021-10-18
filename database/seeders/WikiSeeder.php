<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wiki;
use Illuminate\Support\Facades\DB;

class WikiSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Wiki::factory(3)->create();  // 指定回数分レコード追加
		DB::table('wikis')->truncate(); // 既存データを削除する
		DB::table('wikis')->insert(array(
			array('title' => 'タイトル１','user_id' => '1','team_id' => '1','tags' => '["タグ１","タグ２"]','contents' => '<h1><span style="background-color: rgb(255, 153, 0);">練習</span></h1><h2>練習</h2>','sort' => '1','created_at' => '2021-09-27 03:31:49','updated_at' => '2021-09-27 03:31:49'),
		));
	}
}
