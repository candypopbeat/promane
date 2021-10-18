<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Team;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::truncate();  // 既存データを削除する
		Team::truncate();  // 既存データを削除する
		DB::table('users')->insert([
			[
				'name'      => "master",
				'email'     => "master@change.me",
				'password'  => Hash::make("00000000"),
			],
		]);
		// User::factory(3)->create();  // 指定回数分レコード追加
		DB::table('teams')->insert([
			[
				'user_id'        => 1,
				'name'           => "Team Admin",
				'personal_team'  => 1,
			],
			// [
			// 	'user_id'        => 2,
			// 	'name'           => "Team Admin",
			// 	'personal_team'  => 1,
			// ],
			// [
			// 	'user_id'        => 3,
			// 	'name'           => "Team Admin",
			// 	'personal_team'  => 1,
			// ],
		]);
		Team::factory(3)->create();  // 指定回数分レコード追加
	}
}
