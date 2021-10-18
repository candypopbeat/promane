<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Tasks;
use App\Models\Status;

class ExampleTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_example()
	{
		// $response = $this->get('/');

		$response = Tasks::getAllOrder();
		// $response = Status::getAllOrder();
		dd($response);

		// $response->assertStatus(200);
	}
}
