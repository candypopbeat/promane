<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;
use App\Models\Tasks;

class TaskSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Tasks::factory(3)->create();  // 指定回数分レコード追加
		DB::table('tasks')->truncate(); // 既存データを削除する
		DB::table('tasks')->insert(array(
			array('id' => '1','title' => 'タイトル１','user_id' => '1','team_id' => '1','follow' => '0','status' => '2','tags' => '["海外移転","WEB広告"]','contents' => '<h1>理由</h1><h2>不景気</h2><p>きつい</p><h2>残念</h2><p>大企業</p>','progress' => '64','sort' => '3','start_time' => '2021-10-06 00:00:00','end_time' => '2021-10-16 00:00:00','created_at' => '2021-09-27 05:46:49','updated_at' => '2021-09-27 05:46:49'),
		));
	}
}
