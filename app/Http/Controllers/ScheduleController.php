<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
	public function index()
	{
		$team_id   = Auth::user()->current_team_id;
		$data = Schedule::where("team_id", $team_id);
		return view('schedule', ['schedule' => $data]);
	}

	public function sort(Request $request)
	{
		$data      = !empty($request->input('data')) ? $request->input('data') : "";
		$dataArr   = json_decode(stripslashes($data));
		foreach ($dataArr as $k => $v) {
			DB::table('schedules')
				->where('id', $v->id)
				->update(['sort' => $k]);
		}
		return response()->json("true");
	}

	public function edit(Request $request)
	{
		$id      = !empty($request->input('targetId')) ? $request->input('targetId') : "";
		$title   = !empty($request->input('title')) ? $request->input('title') : "";
		DB::table('schedules')
			->where('id', $id)
			->update(['title' => $title]);
		return response()->json("true");
	}

	public function add(Request $request)
	{
		$title  = $request->input("addTitle");
		$userId = Auth::user()->id;
		$teamId = Auth::user()->current_team_id;
		DB::table('schedules')->insert([
			'title' => $title,
			'user_id' => $userId,
			'team_id' => $teamId,
		]);
		return response()->json("true");
	}

	public function delete(Request $request)
	{
		$targetId = !empty($request->input("targetId")) ? $request->input("targetId") : "";
		Schedule::where('id', $targetId)->delete();
		return response()->json("true");
	}

}
