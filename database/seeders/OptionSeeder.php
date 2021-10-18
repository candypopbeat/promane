<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$colorsJson = [
			"head_title_color" => "white",
			"head_navi_color" => "white",
			"primary_color" => "#0772a3",
			"primary_color_sub" => "#1894ce",
			"primary_color_reverse" => "white",
			"secondary_color" => "#86ace6",
			"secondary_color_sub" => "#a6c6f7",
			"secondary_color_reverse" => "black",
			"success_color" => "yellow",
			"success_color_sub" => "#e9e92b",
			"success_color_reverse" => "black",
			"info_color" => "#0dcaf0",
			"info_color_sub" => "#52defa",
			"info_color_reverse" => "#055464",
			"warning_color" => "#ffc107",
			"warning_color_sub" => "#9e790a",
			"warning_color_reverse" => "black",
			"danger_color" => "#dc3545",
			"danger_color_sub" => "#f04a5b",
			"danger_color_reverse" => "white",
			"light_color" => "#f8f9fa",
			"light_color_sub" => "#dee2e6",
			"light_color_reverse" => "black",
			"dark_color" => "#212529",
			"dark_color_sub" => "#495057",
			"dark_color_reverse" => "white",
		];
		DB::table('options')->insert([
			[
				"team_id" => "6",
				"project_title" => "PUMA",
				"theme_colors" => json_encode($colorsJson),
			],
		]);
	}
}
