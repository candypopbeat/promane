<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
	use HasFactory;
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];
	public static function getAllOrder()
	{
		$team_id   = Auth::user()->current_team_id;
		// $data = self::where("team_id", $team_id)->get();
		$data = self::where("team_id", $team_id)
			->join("users", "users.id", "=", "tasks.user_id")
			->select(
				"tasks.id",
				"tasks.title",
				"tasks.user_id",
				"tasks.follow",
				"tasks.status",
				"tasks.tags",
				"tasks.sort",
				"tasks.start_time",
				"tasks.end_time",
				"tasks.progress",
				"users.name as user_name"
			)
			->get();
		return $data;
	}

	public static function getById($id)
	{
		$data = self::find($id);
		return $data;
	}

	public static function getAllTag()
	{
		$team_id   = Auth::user()->current_team_id;
		$data = self::where("team_id", $team_id)->get();
		$arr = [];
		foreach ($data as $k => $v) {
			$jd = json_decode($v["tags"]);
			$arr = array_merge($jd, $arr);
		}
		$arr = array_unique($arr);
		$res = [];
		foreach ($arr as $k => $v) {
			$obj = [
				"key" => $v,
				"value" => $v
			];
			$res[] = $obj;
		}
		return $res;
	}

	public static function getTheTags($id)
	{
		$data = self::select("tags")->find($id)->tags;
		$data = json_decode($data);
		$res = [];
		foreach ($data as $k => $v) {
			$obj = [
				"key" => $v,
				"value" => $v
			];
			$res[] = $obj;
		}
		return json_encode($res, JSON_UNESCAPED_UNICODE);
	}
}
