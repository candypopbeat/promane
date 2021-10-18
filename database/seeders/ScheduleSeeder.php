<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('schedules')->truncate(); // 既存データを削除する
		DB::table('schedules')->insert(array(
			array('id' => '1', 'team_id' => 1, 'user_id' => 1, 'title' => 'WEB広告','sort' => '2','created_at' => NULL,'updated_at' => NULL),
			array('id' => '2', 'team_id' => 1, 'user_id' => 1, 'title' => 'WEB制作','sort' => '1','created_at' => NULL,'updated_at' => NULL),
			array('id' => '3', 'team_id' => 1, 'user_id' => 1, 'title' => '請求待機','sort' => '3','created_at' => NULL,'updated_at' => NULL),
			array('id' => '4', 'team_id' => 1, 'user_id' => 1, 'title' => '入金まち','sort' => '4','created_at' => NULL,'updated_at' => NULL),
			array('id' => '5', 'team_id' => 1, 'user_id' => 1, 'title' => 'その他','sort' => '5','created_at' => NULL,'updated_at' => NULL)
		));
	}
}
