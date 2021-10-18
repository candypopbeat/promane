<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	use HasFactory;
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];
	public static function getAllOrder()
	{
		$data = self::all()->toArray();
		return $data;
	}
}
