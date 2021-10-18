<?php

namespace Database\Factories;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use DateTime;

class TasksFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Tasks::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$count = rand(0, 3);
		$tags = [];
		for ($i=0; $i < $count; $i++) {
			$tags[] = Str::random(3);
		}
		$tags = json_encode($tags, JSON_UNESCAPED_UNICODE);
		return [
			'title'      => Str::random(20),
			'follow'     => rand(0, 1),
			'status'     => rand(1,5),
			'tags'       => $tags,
			'contents'   => Str::random(50),
			'progress'   => rand(0, 100),
			'start_time' => new DateTime(),
			'end_time'   => new DateTime(),
		];
	}
}
