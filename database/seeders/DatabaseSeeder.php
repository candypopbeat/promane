<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			// OptionSeeder::class,
			// ScheduleSeeder::class,
			StatusSeeder::class, // 稼働させるには最初にこのシーダーを実行せよ
			// TaskSeeder::class,
			// UserSeeder::class,
			// WikiSeeder::class,
		]);
	}
}
