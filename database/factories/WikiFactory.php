<?php

namespace Database\Factories;

use App\Models\Wiki;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WikiFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Wiki::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$count = rand(0, 4);
		$tags = [];
		for ($i=1; $i < $count; $i++) {
			$tags[] = Str::random(3);
		}
		$tags = json_encode($tags, JSON_UNESCAPED_UNICODE);
		return [
			'title'      => Str::random(20),
			'tags'       => $tags,
			'contents'   => $this->faker->realText()
		];
	}
}
