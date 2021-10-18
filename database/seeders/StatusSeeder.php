<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('statuses')->truncate(); // 既存データを削除する
		DB::table('statuses')->insert([
			[
				'name'      => '待機中',
			],
			[
				'name'      => '処理中',
			],
			[
				'name'      => '確認中',
			],
			[
				'name'      => '完了',
			],
			[
				'name'      => 'アーカイブ',
			],
		]);
	}
}
